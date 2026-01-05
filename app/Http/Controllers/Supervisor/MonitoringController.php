<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\TaskReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    public function index()
{
    $tasks = TaskReport::with(['pic.division'])
        ->whereHas('pic', function ($q) {
            $q->where('division_id', auth()->user()->division_id)
              ->where('role', 'PIC');
        })
        ->latest()
        ->paginate(10);

    return view('supervisor.monitoring', compact('tasks'));
}

    public function show(TaskReport $task)
{
    $task->load('pic.division');

    return view('supervisor.monitoring-show', compact('task'));
}
    public function feedback(Request $request, TaskReport $task)
    {
        $request->validate([
            'feedback' => 'required|string'
        ]);

        $task->update([
            'feedback' => $request->feedback,
            'status'   => 'review'
        ]);

        return back()->with('success','Feedback dikirim');
    }

    public function revision(Request $request, TaskReport $task)
    {
        $request->validate([
            'note' => 'required|string'
        ]);

        $task->update([
            'revision_note' => $request->note,
            'status'        => 'revision'
        ]);

        return back()->with('success','Revisi diminta');
    }
}
