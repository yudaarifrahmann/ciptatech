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
    /*
    |--------------------------------------------------------------------------
    | LIST TASK GROUP
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $supervisor = Auth::user();

        $tasks = Task::where('supervisor_id', $supervisor->id)
            ->whereNull('task_group_id') // parent only
            ->with(['division', 'children', 'latestSubmission'])
            ->latest()
            ->paginate(10);

        return view('supervisor.tasks.index', compact('tasks'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $supervisor = Auth::user();
        $division = $supervisor->division;

        if (!$division) {
            return redirect()
                ->route('supervisor.tasks.index')
                ->with('error', 'Anda belum ditugaskan ke divisi manapun');
        }

        return view('supervisor.tasks.create', compact('division'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE (MULTI TASK)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $supervisor = Auth::user();
        $division = $supervisor->division;

        if (!$division) {
            return redirect()
                ->route('supervisor.tasks.index')
                ->with('error', 'Anda belum ditugaskan ke divisi manapun');
        }

        $validated = $request->validate([
            'deadline' => 'required|date|after_or_equal:today',
            'tasks' => 'required|array|min:1',
            'tasks.*.title' => 'required|string|max:255',
            'tasks.*.description' => 'nullable|string',
        ]);

        /*
        |--------------------------------------------------
        | 1️⃣ CREATE PARENT TASK (GROUP)
        |--------------------------------------------------
        */
        $taskGroup = Task::create([
            'division_id'   => $division->id,
            'supervisor_id' => $supervisor->id,
            'title'         => 'Tugas Divisi ' . $division->name,
            'description'   => 'Kumpulan tugas',
            'deadline'      => $validated['deadline'],
            'status'        => 'assigned',
            'task_group_id' => null,
        ]);

        /*
        |--------------------------------------------------
        | 2️⃣ CREATE CHILD TASKS
        |--------------------------------------------------
        */
        foreach ($validated['tasks'] as $index => $item) {
            Task::create([
                'division_id'     => $division->id,
                'supervisor_id'   => $supervisor->id,
                'title'           => $item['title'],
                'task_item_title' => $item['title'],
                'description'     => $item['description'] ?? null,
                'deadline'        => $validated['deadline'],
                'status'          => 'assigned',
                'task_group_id'   => $taskGroup->id,
                'task_order'      => $index + 1,
            ]);
        }

        /*
        |--------------------------------------------------
        | 3️⃣ ASSIGN KE SEMUA PIC
        |--------------------------------------------------
        */
        $pics = User::where('division_id', $division->id)
            ->where('role', 'PIC')
            ->where('is_active', true)
            ->get();

        foreach ($pics as $pic) {
            TaskSubmission::create([
                'task_id' => $taskGroup->id,
                'pic_id'  => $pic->id,
                'status'  => 'submitted',
                'completed_tasks_count' => 0,
            ]);
        }

        return redirect()
            ->route('supervisor.tasks.index')
            ->with('success', 'Tugas berhasil dibuat dan ditugaskan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show(Task $task)
    {
        $this->authorizeSupervisor($task);

        $task->load([
            'division',
            'children',
            'submissions.pic',
        ]);

        return view('supervisor.tasks.show', compact('task'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Task $task)
    {
        $this->authorizeSupervisor($task);

        return view('supervisor.tasks.edit', compact('task'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Task $task)
    {
        $this->authorizeSupervisor($task);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date|after_or_equal:today',
        ]);

        $task->update($validated);

        return redirect()
            ->route('supervisor.tasks.show', $task)
            ->with('success', 'Tugas berhasil diperbarui');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(Task $task)
    {
        $this->authorizeSupervisor($task);

        $task->children()->delete();
        $task->submissions()->delete();
        $task->delete();

        return redirect()
            ->route('supervisor.tasks.index')
            ->with('success', 'Tugas berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | REVIEW SUBMISSIONS
    |--------------------------------------------------------------------------
    */
    public function reviewSubmissions(Task $task)
    {
        $this->authorizeSupervisor($task);

        $task->load('submissions.pic');

        return view(
            'supervisor.tasks.review-submissions',
            ['task' => $task, 'submissions' => $task->submissions]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | APPROVE
    |--------------------------------------------------------------------------
    */
    public function approveSubmission(TaskSubmission $submission)
    {
        $task = $submission->task;
        $this->authorizeSupervisor($task);

        $submission->update([
            'status' => 'approved',
            'reviewed_at' => now(),
        ]);

        $task->update([
            'status' => 'approved',
        ]);

        return back()->with(
            'success',
            "Submission {$submission->pic->name} disetujui."
        );
    }

    /*
    |--------------------------------------------------------------------------
    | REJECT
    |--------------------------------------------------------------------------
    */
    public function rejectSubmission(Request $request, TaskSubmission $submission)
    {
        $task = $submission->task;
        $this->authorizeSupervisor($task);

        $validated = $request->validate([
            'reviewer_feedback' => 'required|string|min:10',
        ]);

        $submission->update([
            'status' => 'rejected',
            'reviewer_feedback' => $validated['reviewer_feedback'],
            'reviewed_at' => now(),
        ]);

        $task->update([
            'status' => 'submitted',
        ]);

        return back()->with(
            'success',
            "Submission {$submission->pic->name} ditolak."
        );
    }

    /*
    |--------------------------------------------------------------------------
    | AUTH CHECK
    |--------------------------------------------------------------------------
    */
    private function authorizeSupervisor(Task $task)
    {
        if ($task->supervisor_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}
