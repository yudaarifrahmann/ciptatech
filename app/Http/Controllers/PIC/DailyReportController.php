<?php

namespace App\Http\Controllers\Pic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyReport;

class DailyReportController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $schema = \App\Models\FormSchema::where('division_id', $user->division_id)
            ->where('form_type', 'daily')
            ->where('is_active', true)
            ->first();

        return view('pic.daily-report', compact('schema'));
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

        // Dynamic Validation & Processing
        $schema = \App\Models\FormSchema::where('division_id', $user->division_id)
            ->where('form_type', 'daily')
            ->where('is_active', true)
            ->first();
        $additionalData = [];
        
        if ($schema && is_array($schema->schema)) {
            foreach ($schema->schema as $field) {
                $fieldName = $field['label'];
                
                if ($field['type'] == 'file') {
                    if ($request->hasFile("additional_files.$fieldName")) {
                        $path = $request->file("additional_files.$fieldName")->store('daily_reports/additional', 'public');
                        $additionalData[$fieldName] = $path;
                    } elseif (isset($field['required']) && $field['required']) {
                        return redirect()->back()->withErrors([$fieldName => "Field $fieldName wajib diisi."])->withInput();
                    }
                } else {
                    $val = $request->input("additional_data.$fieldName");
                    if (isset($field['required']) && $field['required'] && empty($val)) {
                        return redirect()->back()->withErrors([$fieldName => "Field $fieldName wajib diisi."])->withInput();
                    }
                    $additionalData[$fieldName] = $val;
                }
            }
        }

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
            'organization_id' => $user->organization_id,
            'report_date'  => $request->report_date,
            'task'         => $request->task,
            'description'  => $request->description,
            'documentation'=> $filePath,
            'video'        => $videoPath,
            'github_link'  => $githubLink,
            'additional_data' => $additionalData,
        ]);

        return redirect()->route('pic.dashboard')->with('success', 'Daily report berhasil disimpan dan dikirim!');
    }
}
 