<?php
namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\TaskReport;
use App\Models\DailyReport;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total laporan masuk
        $totalReports = TaskReport::count();
        
        // Laporan yang disetujui
        $approvedReports = TaskReport::where('status', 'approved')->count();
        
        // Laporan menunggu atau revisi
        $pendingRevision = TaskReport::whereIn('status', ['pending', 'revision'])->count();
        
        // Total divisi aktif
        $totalDivisions = Division::where('is_active', true)->count();
        
        // Dapatkan semua PIC di organisasi ini dengan statistik laporan mereka
        $pics = User::where('role', 'PIC')
            ->where('is_active', true)
            ->with(['taskReports' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }, 'division'])
            ->get()
            ->map(function ($pic) {
                $latestReport = $pic->taskReports->first();
                $avgProgress = $pic->taskReports->avg('progress') ?? 0;
                
                // Tentukan status berdasarkan progress rata-rata
                if ($avgProgress >= 80) {
                    $statusLabel = 'Sangat Aktif';
                    $statusColor = 'info';
                    $statusIcon = 'fa-fire';
                } elseif ($avgProgress >= 50) {
                    $statusLabel = 'Produktif';
                    $statusColor = 'success';
                    $statusIcon = 'fa-check';
                } else {
                    $statusLabel = 'Perlu Support';
                    $statusColor = 'warning';
                    $statusIcon = 'fa-hands-helping';
                }

                $pic->latest_task = $latestReport ? $latestReport->task->title ?? 'Tugas Lapangan' : 'Belum ada tugas';
                $pic->avg_progress = round($avgProgress, 0);
                $pic->status_label = $statusLabel;
                $pic->status_color = $statusColor;
                $pic->status_icon = $statusIcon;
                
                return $pic;
            });
        
        // Laporan yang menunggu review (tetap sama)
        $pendingReviews = TaskReport::where('status', 'pending')
            ->with(['pic.division', 'task'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($report) {
                $report->division_name = $report->pic->division->name ?? 'N/A';
                $report->task_name = $report->task->title ?? 'Laporan Tugas';
                $report->deadline = $report->created_at->addDays(3)->format('j M');
                return $report;
            });
        
        // Statistik laporan berdasarkan status
        $reportStats = [
            'approved' => TaskReport::where('status', 'approved')->count(),
            'pending' => TaskReport::where('status', 'pending')->count(),
            'revision' => TaskReport::where('status', 'revisi')->count(),
        ];
        
        return view('supervisor.dashboard', [
            'totalReports' => $totalReports,
            'approvedReports' => $approvedReports,
            'pendingRevision' => $pendingRevision,
            'totalDivisions' => $totalDivisions,
            'pics' => $pics,
            'pendingReviews' => $pendingReviews,
            'reportStats' => $reportStats,
        ]);
    }
}
