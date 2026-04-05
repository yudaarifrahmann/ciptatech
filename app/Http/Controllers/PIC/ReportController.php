<?php
namespace App\Http\Controllers\PIC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskReport;
use App\Models\FormSchema;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $schema = FormSchema::where('division_id', $user->division_id)
            ->where('form_type', 'weekly')
            ->where('is_active', true)
            ->first();

        return view('pic.report-create', compact('schema'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required',
            'progress' => 'required|integer|min:0|max:100',
            'description' => 'required',
            'file' => 'nullable|file|max:5120'
        ]);

        return redirect('/pic/report/history')
            ->with('success', 'Laporan berhasil dikirim');
    }

    public function history()
    {
        $userId = Auth::id();

        $reports = TaskReport::where('user_id', $userId)
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => TaskReport::where('user_id', $userId)->count(),
            'draft' => TaskReport::where('user_id', $userId)->where('status', 'draft')->count(),
            'progress' => TaskReport::where('user_id', $userId)->where('status', 'progress')->count(),
            'review' => TaskReport::where('user_id', $userId)->where('status', 'menunggu review')->count(),
            'revisi' => TaskReport::where('user_id', $userId)->where('status', 'revisi')->count(),
            'selesai' => TaskReport::where('user_id', $userId)->where('status', 'selesai')->count(),
        ];

        return view('pic.report-history', compact('reports', 'stats'));
    }

    public function show($id)
    {
        $report = TaskReport::findOrFail($id);
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }
        return view('pic.report-show', compact('report'));
    }

    public function edit($id)
    {
        $report = TaskReport::findOrFail($id);
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }
        return view('pic.report-edit', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $report = TaskReport::findOrFail($id);
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'task_name' => 'required|string|max:255',
            'progress' => 'required|integer|min:0|max:100',
            'description' => 'required|string',
            'file' => 'nullable|file|max:10240',
            'video' => 'nullable|mimetypes:video/mp4,video/mpeg,video/quicktime,video/x-msvideo,video/x-matroska',
            'github_link' => 'nullable|url|regex:/https:\/\/.*github\.com\/.*/'
        ]);

        $data = [
            'task_name' => $request->task_name,
            'progress' => $request->progress,
            'description' => $request->description,
            'github_link' => $request->github_link,
        ];

        if ($request->progress == 100) {
            $data['status'] = 'menunggu review';
        } else {
            if ($report->status == 'menunggu review') {
                 $data['status'] = 'progress';
            }
        }

        if ($request->hasFile('file')) {
            if ($report->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($report->file_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($report->file_path);
            }
            $data['file_path'] = $request->file('file')->store('task_reports', 'public');
        }

        if ($request->hasFile('video')) {
            if ($report->video && \Illuminate\Support\Facades\Storage::disk('public')->exists($report->video)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($report->video);
            }
            $data['video'] = $request->file('video')->store('task_reports/videos', 'public');
        }

        $report->update($data);

        return redirect()->route('pic.report.history')
            ->with('success', 'Laporan berhasil diperbarui');
    }
}
