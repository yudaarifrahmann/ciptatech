<?php

namespace App\Http\Controllers\PIC;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        $pic = Auth::user();
        $division = $pic->division;

        if (!$division) {
            return view('pic.tasks.index', ['submissions' => []]);
        }

        // Get task submissions for this PIC from parent tasks only (task_group_id is null)
        $submissions = TaskSubmission::where('pic_id', $pic->id)
            ->with(['task' => function ($query) {
                $query->where('task_group_id', null)->with('supervisor');
            }])
            ->get()
            ->filter(function ($submission) {
                return $submission->task !== null; // Only parent tasks
            })
            ->values();

        return view('pic.tasks.index', compact('submissions'));
    }

    public function show(Task $task)
    {
        $pic = Auth::user();
        $division = $pic->division;

        if ($task->division_id !== $division->id) {
            abort(403, 'Unauthorized');
        }

        $mySubmission = TaskSubmission::where('task_id', $task->id)
            ->where('pic_id', $pic->id)
            ->first();

        if (!$mySubmission) {
            abort(404, 'Submission tidak ditemukan');
        }

        $task->load('supervisor');

        return view('pic.tasks.show', compact('task', 'mySubmission'));
    }

    public function submitWork(Request $request, Task $task)
    {
        $pic = Auth::user();
        $division = $pic->division;

        if ($task->division_id !== $division->id) {
            abort(403, 'Unauthorized');
        }

        $mySubmission = TaskSubmission::where('task_id', $task->id)
            ->where('pic_id', $pic->id)
            ->first();

        if (!$mySubmission) {
            abort(404, 'Submission tidak ditemukan');
        }

        // Cannot submit if already approved
        if ($mySubmission->status === 'approved') {
            return redirect()->back()
                ->with('error', 'Tugas ini sudah disetujui dan tidak bisa diubah lagi');
        }

        $validated = $request->validate([
            'submission_notes' => 'required|string|min:10',
            'submission_file' => 'nullable|file|max:10240', // Max 10MB
        ]);

        $filePath = null;
        if ($request->hasFile('submission_file')) {
            $filePath = $request->file('submission_file')->store('submissions');
        }

        $mySubmission->update([
            'submission_notes' => $validated['submission_notes'],
            'submission_file' => $filePath ?? $mySubmission->submission_file,
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        // Update task status to submitted
        $task->update(['status' => 'submitted']);

        return redirect()->route('pic.tasks.show', $task)
            ->with('success', 'Pekerjaan Anda berhasil dikirim ke supervisor untuk ditinjau');
    }

    public function getSubmissionProgress()
    {
        $pic = Auth::user();
        $division = $pic->division;

        if (!$division) {
            return response()->json([
                'total_tasks' => 0,
                'completed_tasks' => 0,
                'pending_tasks' => 0,
                'rejected_tasks' => 0,
            ]);
        }

        $tasks = Task::where('division_id', $division->id)
            ->where('status', '!=', 'pending')
            ->get();

        $completed = 0;
        $pending = 0;
        $rejected = 0;

        foreach ($tasks as $task) {
            $submission = $task->submissions->where('pic_id', $pic->id)->first();
            
            if ($submission) {
                if ($submission->status === 'approved') {
                    $completed++;
                } elseif ($submission->status === 'rejected') {
                    $rejected++;
                } else {
                    $pending++;
                }
            }
        }

        return response()->json([
            'total_tasks' => count($tasks),
            'completed_tasks' => $completed,
            'pending_tasks' => $pending,
            'rejected_tasks' => $rejected,
        ]);
    }

    public function completeTaskItem(Request $request, Task $task)
    {
        $pic = Auth::user();
        
        // Get the parent task (task_group_id is null)
        $parentTask = $task->task_group_id ? Task::find($task->task_group_id) : $task;
        
        // Get the submission for this task group
        $submission = TaskSubmission::where('task_id', $parentTask->id)
            ->where('pic_id', $pic->id)
            ->first();

        if (!$submission) {
            return response()->json([
                'success' => false,
                'message' => 'Submission tidak ditemukan',
            ], 404);
        }

        // Check if task is already completed
        $completed = \DB::table('completed_tasks')
            ->where('task_submission_id', $submission->id)
            ->where('task_id', $task->id)
            ->exists();

        if ($completed) {
            return response()->json([
                'success' => false,
                'message' => 'Tugas ini sudah ditandai selesai',
            ], 400);
        }

        try {
            // Handle file upload
            $evidencePath = null;
            if ($request->hasFile('evidence')) {
                $evidencePath = $request->file('evidence')->store('task-evidence/' . $submission->id);
            }

            // Mark task as completed
            \DB::table('completed_tasks')->insert([
                'task_submission_id' => $submission->id,
                'task_id' => $task->id,
                'completed_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Increment completed count
            $submission->increment('completed_tasks_count');

            // Store evidence and notes if provided
            if ($evidencePath || $request->has('notes')) {
                $notes = $submission->submission_notes ?? '';
                if ($request->has('notes') && $request->input('notes')) {
                    $notes .= "\n\n[Task: {$task->task_item_title}]\n{$request->input('notes')}";
                    $notes = trim($notes);
                }
                
                if ($notes) {
                    $submission->update(['submission_notes' => $notes]);
                }
                
                if ($evidencePath) {
                    // Store evidence file path - append to submission_file
                    $files = $submission->submission_file ? explode('|', $submission->submission_file) : [];
                    $files[] = $evidencePath;
                    $submission->update(['submission_file' => implode('|', $files)]);
                }
            }

            // Check if all tasks are completed
            $childTasks = Task::where('task_group_id', $parentTask->id)->count();
            $totalCompleted = \DB::table('completed_tasks')
                ->where('task_submission_id', $submission->id)
                ->count();

            if ($totalCompleted === $childTasks) {
                $submission->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tugas berhasil ditandai selesai',
                'completed_count' => $totalCompleted,
                'total_count' => $childTasks,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
