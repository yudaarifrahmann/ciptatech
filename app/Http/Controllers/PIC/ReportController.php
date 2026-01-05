<?php
namespace App\Http\Controllers\PIC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskReport;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function create()
    {
        return view('pic.report-create');
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
        'selesai' => TaskReport::where('user_id', $userId)->where('status', 'selesai')->count(),
    ];

    return view('pic.report-history', compact('reports', 'stats'));
}
}
