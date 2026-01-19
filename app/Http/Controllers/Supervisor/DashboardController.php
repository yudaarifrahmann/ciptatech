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
        
        // Dapatkan semua divisi dengan statistik
        $divisions = Division::where('is_active', true)
            ->with(['users' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get()
            ->map(function ($division) {
                // Hitung progress rata-rata untuk divisi ini
                $tasksCount = TaskReport::whereIn('user_id', $division->users->pluck('id'))->count();
                
                if ($tasksCount == 0) {
                    $avgProgress = 0;
                } else {
                    $avgProgress = TaskReport::whereIn('user_id', $division->users->pluck('id'))
                        ->avg('progress') ?? 0;
                }
                
                // Tentukan status berdasarkan progress
                if ($avgProgress >= 80) {
                    $status = 'optimal';
                    $statusLabel = 'Optimal';
                    $statusColor = 'info';
                    $statusIcon = 'fa-tachometer-alt';
                } elseif ($avgProgress >= 70) {
                    $status = 'on-track';
                    $statusLabel = 'On Track';
                    $statusColor = 'success';
                    $statusIcon = 'fa-check-circle';
                } elseif ($avgProgress >= 50) {
                    $status = 'attention';
                    $statusLabel = 'Perlu Perhatian';
                    $statusColor = 'warning';
                    $statusIcon = 'fa-exclamation-triangle';
                } else {
                    $status = 'critical';
                    $statusLabel = 'Kritis';
                    $statusColor = 'danger';
                    $statusIcon = 'fa-exclamation-circle';
                }
                
                $division->avg_progress = round($avgProgress, 0);
                $division->active_projects = $tasksCount;
                $division->status = $status;
                $division->status_label = $statusLabel;
                $division->status_color = $statusColor;
                $division->status_icon = $statusIcon;
                
                return $division;
            });
        
        // Laporan yang menunggu review
        $pendingReviews = TaskReport::where('status', 'pending')
            ->with('pic')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get()
            ->map(function ($report) {
                $report->division_name = $report->pic->division->name ?? 'N/A';
                $report->deadline = $report->created_at->addDays(5)->format('j M');
                return $report;
            });
        
        // Statistik laporan berdasarkan status
        $reportStats = [
            'approved' => TaskReport::where('status', 'approved')->count(),
            'pending' => TaskReport::where('status', 'pending')->count(),
            'revision' => TaskReport::where('status', 'revision')->count(),
        ];
        
        return view('supervisor.dashboard', [
            'totalReports' => $totalReports,
            'approvedReports' => $approvedReports,
            'pendingRevision' => $pendingRevision,
            'totalDivisions' => $totalDivisions,
            'divisions' => $divisions,
            'pendingReviews' => $pendingReviews,
            'reportStats' => $reportStats,
        ]);
    }
}
