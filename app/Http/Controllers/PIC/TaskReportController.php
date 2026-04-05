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
        $user = auth()->user();
        $isMultimedia = $user->division_id == 1; // Cek apakah dari divisi Multimedia
        $isSoftwareHost = $user->division_id == 3; // Cek apakah dari divisi Software Host
        
        // Validasi dasar
        $rules = [
            'task_name'   => 'required|string|max:255',
            'description' => 'nullable|string',
            'progress'    => 'required|integer|min:0|max:100',
            'file'        => 'nullable|file|max:10240',
        ];
        
        // Tambah validasi video hanya jika dari divisi Multimedia
        if ($isMultimedia) {
            $rules['video'] = 'nullable|mimetypes:video/mp4,video/mpeg,video/quicktime,video/x-msvideo,video/x-matroska';
        }
        
        // Tambah validasi github_link hanya jika dari divisi Software Host
        if ($isSoftwareHost) {
            $rules['github_link'] = 'nullable|url|regex:/https:\/\/.*github\.com\/.*/';
        }
        
        $request->validate($rules);

        $status = 'progress';
        if ($request->progress == 100) {
            $status = 'menunggu review';
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')
                ->store('task_reports', 'public');
        }
        
        $videoPath = null;
        if ($isMultimedia && $request->hasFile('video')) {
            $videoPath = $request->file('video')->store('task_reports/videos', 'public');
        }
        
        $githubLink = null;
        if ($isSoftwareHost && $request->has('github_link')) {
            $githubLink = $request->github_link;
        }

        TaskReport::create([
            'user_id'    => Auth::id(),
            'task_name'  => $request->task_name,
            'description'=> $request->description,
            'progress'   => $request->progress,
            'file_path'  => $filePath,
            'video'      => $videoPath,
            'github_link'=> $githubLink,
            'status'     => $status,
        ]);

        return redirect()->route('pic.dashboard')
            ->with('success', 'Laporan tugas berhasil dikirim');
    }
}

