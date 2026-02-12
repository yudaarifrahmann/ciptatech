<?php

namespace App\Http\Controllers\Pic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyReport;

class DailyReportController extends Controller
{
    public function index()
    {
        return view('pic.daily-report');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $isMultimedia = $user->division_id == 1;
        $isSoftwareHost = $user->division_id == 3;
        
        $rules = [
            'report_date' => 'required|date',
            'task'        => 'required|string|max:255',
            'description' => 'required|string',
            'documentation' => 'nullable|image|max:2048',
        ];
        
        if ($isMultimedia) {
            $rules['video'] = 'nullable|mimetypes:video/mp4,video/mpeg,video/quicktime,video/x-msvideo,video/x-matroska';
        }
        
        if ($isSoftwareHost) {
            $rules['github_link'] = 'nullable|url|regex:/https:\/\/.*github\.com\/.*/';
        }
        
        $request->validate($rules);

        $filePath = null;
        if ($request->hasFile('documentation')) {
            $filePath = $request->file('documentation')->store('daily-report', 'public');
        }
        
        $videoPath = null;
        if ($isMultimedia && $request->hasFile('video')) {
            $videoPath = $request->file('video')->store('daily-report/videos', 'public');
        }
        
        $githubLink = null;
        if ($isSoftwareHost && $request->has('github_link')) {
            $githubLink = $request->github_link;
        }

        DailyReport::create([
            'user_id'      => auth()->id(),
            'report_date'  => $request->report_date,
            'task'         => $request->task,
            'description'  => $request->description,
            'documentation'=> $filePath,
            'video'        => $videoPath,
            'github_link'  => $githubLink,
        ]);

        return back()->with('success', 'Daily report berhasil disimpan');
    }
}
 