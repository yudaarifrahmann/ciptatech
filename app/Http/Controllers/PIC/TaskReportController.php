<?php

namespace App\Http\Controllers\Pic;

use App\Http\Controllers\Controller;
use App\Models\TaskReport;
use App\Models\FormSchema;
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

        // Dynamic Validation & Processing
        $schema = FormSchema::where('division_id', $user->division_id)
            ->where('form_type', 'weekly')
            ->where('is_active', true)
            ->first();
        $additionalData = [];
        
        if ($schema && is_array($schema->schema)) {
            foreach ($schema->schema as $field) {
                $fieldName = $field['label'];
                
                if ($field['type'] == 'file') {
                    if ($request->hasFile("additional_files.$fieldName")) {
                        $path = $request->file("additional_files.$fieldName")->store('task_reports/additional', 'public');
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

        $status = 'progress';
        if ($request->progress == 100) {
            $status = 'menunggu review';
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')
                ->store('task_reports', 'public');
        }
        
        // Final creation
        TaskReport::create([
            'user_id'         => Auth::id(),
            'organization_id' => $user->organization_id, // Implicitly handled by trait, but good to be explicit
            'task_name'       => $request->task_name,
            'description'     => $request->description,
            'progress'        => $request->progress,
            'file_path'       => $filePath,
            'video'           => $videoPath ?? null,
            'github_link'     => $githubLink ?? null,
            'additional_data' => $additionalData,
            'status'          => $status,
        ]);

        return redirect()->route('pic.dashboard')
            ->with('success', 'Laporan tugas berhasil dikirim');
    }
}

