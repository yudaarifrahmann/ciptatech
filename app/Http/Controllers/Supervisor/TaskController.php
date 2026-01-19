<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $supervisor = Auth::user();
        
        // Get tasks created by this supervisor
        $tasks = Task::where('supervisor_id', $supervisor->id)
            ->with('division', 'submissions')
            ->latest()
            ->paginate(10);

        return view('supervisor.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $supervisor = Auth::user();
        $division = $supervisor->division;

        if (!$division) {
            return redirect()->route('supervisor.tasks.index')
                ->with('error', 'Anda belum ditugaskan ke divisi manapun');
        }

        // Get all PIC in this division
        $pics = User::where('division_id', $division->id)
            ->where('role', 'PIC')
            ->where('is_active', true)
            ->get();

        return view('supervisor.tasks.create', compact('division', 'pics'));
    }

    public function store(Request $request)
    {
        $supervisor = Auth::user();
        $division = $supervisor->division;

        if (!$division) {
            return redirect()->route('supervisor.tasks.index')
                ->with('error', 'Anda belum ditugaskan ke divisi manapun');
        }

        $validated = $request->validate([
            'main_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date|after_or_equal:today',
            'tasks' => 'required|array|min:1',
            'tasks.*.title' => 'required|string|max:255',
        ]);

        // Create task group
        $taskGroup = Task::create([
            'division_id' => $division->id,
            'supervisor_id' => $supervisor->id,
            'title' => $validated['main_title'],
            'description' => $validated['description'],
            'deadline' => $validated['deadline'],
            'status' => 'pending',
            'task_group_id' => null, // Parent task
        ]);

        // Create individual tasks
        foreach ($validated['tasks'] as $order => $taskData) {
            Task::create([
                'division_id' => $division->id,
                'supervisor_id' => $supervisor->id,
                'title' => $validated['main_title'],
                'task_item_title' => $taskData['title'],
                'description' => $validated['description'],
                'deadline' => $validated['deadline'],
                'status' => 'pending',
                'task_group_id' => $taskGroup->id,
                'task_order' => $order,
            ]);
        }

        // Auto-assign to all PIC in division
        $pics = User::where('division_id', $division->id)
            ->where('role', 'PIC')
            ->where('is_active', true)
            ->pluck('id');

        foreach ($pics as $pic_id) {
            TaskSubmission::create([
                'task_id' => $taskGroup->id,
                'pic_id' => $pic_id,
                'status' => 'submitted',
                'completed_tasks_count' => 0,
            ]);
        }

        $taskGroup->update(['status' => 'assigned']);

        return redirect()->route('supervisor.tasks.index')
            ->with('success', "Tugas grup '{$taskGroup->title}' dengan " . count($validated['tasks']) . " item tugas berhasil dibuat dan ditugaskan ke semua PIC di divisi Anda");
    }

    public function show(Task $task)
    {
        $supervisor = Auth::user();

        if ($task->supervisor_id !== $supervisor->id) {
            abort(403, 'Unauthorized');
        }

        $task->load('division', 'supervisor', 'submissions.pic');

        return view('supervisor.tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $supervisor = Auth::user();

        if ($task->supervisor_id !== $supervisor->id) {
            abort(403, 'Unauthorized');
        }

        return view('supervisor.tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $supervisor = Auth::user();

        if ($task->supervisor_id !== $supervisor->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date|after_or_equal:today',
        ]);

        $task->update($validated);

        return redirect()->route('supervisor.tasks.show', $task)
            ->with('success', 'Tugas berhasil diperbarui');
    }

    public function destroy(Task $task)
    {
        $supervisor = Auth::user();

        if ($task->supervisor_id !== $supervisor->id) {
            abort(403, 'Unauthorized');
        }

        $taskTitle = $task->title;
        $task->delete();

        return redirect()->route('supervisor.tasks.index')
            ->with('success', "Tugas '{$taskTitle}' telah dihapus");
    }

    // Review submissions from PIC
    public function reviewSubmissions(Task $task)
    {
        $supervisor = Auth::user();

        if ($task->supervisor_id !== $supervisor->id) {
            abort(403, 'Unauthorized');
        }

        $task->load('submissions.pic');
        $submissions = $task->submissions;

        return view('supervisor.tasks.review-submissions', compact('task', 'submissions'));
    }

    public function approveSubmission(TaskSubmission $submission)
    {
        $supervisor = Auth::user();
        $task = $submission->task;

        if ($task->supervisor_id !== $supervisor->id) {
            abort(403, 'Unauthorized');
        }

        $submission->update([
            'status' => 'approved',
            'reviewed_at' => now(),
        ]);

        $task->update(['status' => 'approved']);

        return redirect()->back()
            ->with('success', "Submission dari {$submission->pic->name} berhasil disetujui. Tugas selesai!");
    }

    public function rejectSubmission(Request $request, TaskSubmission $submission)
    {
        $supervisor = Auth::user();
        $task = $submission->task;

        if ($task->supervisor_id !== $supervisor->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'reviewer_feedback' => 'required|string|min:10',
        ]);

        $submission->update([
            'status' => 'rejected',
            'reviewer_feedback' => $validated['reviewer_feedback'],
            'reviewed_at' => now(),
        ]);

        $task->update(['status' => 'submitted']);

        return redirect()->back()
            ->with('success', "Submission dari {$submission->pic->name} telah ditolak. PIC dapat memperbaiki kembali.");
    }
}
