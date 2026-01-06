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
    $supervisor = Auth::user();
    $divisionId = $supervisor->division_id;

    $pics = User::where('role', 'PIC')
                 ->where('division_id', $divisionId)
                 ->pluck('id');

    $baseQuery = TaskReport::whereIn('user_id', $pics);

    $totalTasks = (clone $baseQuery)->count(); 
    
    $waitingReview = (clone $baseQuery)->where('status', 'Menunggu Review')->count();
    $completed = (clone $baseQuery)->where('status', 'Tuntas')->count();
    
    $averageProgress = (clone $baseQuery)->avg('progress') ?? 0;

    $tasks = $baseQuery->paginate(10);

    return view('supervisor.monitoring', compact(
        'tasks',
        'totalTasks',
        'waitingReview',
        'completed',
        'averageProgress'
    ));
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

    public function storeComment(Request $request, $id)
{
    $request->validate([
        'comment' => 'required|string|max:1000',
    ]);

    // PERBAIKAN: Ganti Task menjadi TaskReport
    $task = \App\Models\TaskReport::findOrFail($id);

    // Sesuaikan dengan kolom di database Anda (sepertinya 'feedback')
    $task->update([
        'feedback' => $request->comment 
    ]);

    return back()->with('success', 'Komentar berhasil ditambahkan!');
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

    public function updateStatus(Request $request, TaskReport $task)
{
    $validStatuses = ['selesai', 'progress']; 
    $newStatus = strtolower($request->input('status'));

    if (!in_array($newStatus, $validStatuses)) {
        return response()->json(['success' => false, 'message' => 'Status tidak valid.'], 400);
    }
    
    try {
        $task->status = $newStatus;
        $task->save();

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui.']);

    } catch (\Exception $e) {
    }
}
}