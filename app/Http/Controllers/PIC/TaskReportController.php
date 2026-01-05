<?php

namespace App\Http\Controllers\Pic;

use App\Http\Controllers\Controller;
use App\Models\TaskReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'task_name'   => 'required|string|max:255',
            'description' => 'nullable|string',
            'progress'    => 'required|integer|min:0|max:100',
            'file'        => 'nullable|file|max:10240',
        ]);

        $status = 'progress';
        if ($request->progress == 100) {
            $status = 'menunggu review';
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')
                ->store('task_reports', 'public');
        }

        TaskReport::create([
            'user_id'    => Auth::id(),
            'task_name'  => $request->task_name,
            'description'=> $request->description,
            'progress'   => $request->progress,
            'file_path'  => $filePath,
            'status'     => $status,
        ]);

        return redirect()->route('pic.dashboard')
            ->with('success', 'Laporan tugas berhasil dikirim');
    }
}

