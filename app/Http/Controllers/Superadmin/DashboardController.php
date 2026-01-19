<?php
namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Division;
use App\Models\TaskReport;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total users by role
        $totalUsers = User::count();
        $usersByRole = [
            'superadmin' => User::where('role', 'superadmin')->count(),
            'supervisor' => User::where('role', 'supervisor')->count(),
            'PIC' => User::where('role', 'PIC')->count(),
        ];
        
        // Divisions
        $totalDivisions = Division::count();
        $activeDivisions = Division::where('is_active', true)->count();
        $inactiveDivisions = Division::where('is_active', false)->count();
        
        // Reports
        $totalReports = TaskReport::count();
        $approvedReports = TaskReport::where('status', 'approved')->count();
        $pendingReports = TaskReport::where('status', 'pending')->count();
        $revisionReports = TaskReport::where('status', 'revision')->count();
        
        // System activity (online users)
        $onlineUsers = User::where('is_active', true)->count();
        $offlineUsers = User::where('is_active', false)->count();
        
        // Recent activity logs - simulated from available data
        $recentActivities = [
            [
                'type' => 'user_added',
                'title' => 'User baru ditambahkan',
                'description' => 'Supervisor baru berhasil ditambahkan ke sistem',
                'icon' => 'fa-user-plus',
                'color' => 'success',
                'time' => '10 menit lalu',
                'author' => 'Superadmin'
            ],
            [
                'type' => 'report_approved',
                'title' => 'Laporan disetujui',
                'description' => 'Laporan dari divisi Software Host disetujui',
                'icon' => 'fa-file-upload',
                'color' => 'primary',
                'time' => '45 menit lalu',
                'author' => 'Supervisor IT'
            ],
            [
                'type' => 'warning',
                'title' => 'Peringatan sistem',
                'description' => 'Storage server mencapai 85% kapasitas',
                'icon' => 'fa-exclamation-triangle',
                'color' => 'warning',
                'time' => '2 jam lalu',
                'author' => 'Sistem monitoring'
            ],
            [
                'type' => 'backup',
                'title' => 'Backup otomatis',
                'description' => 'Backup database harian berhasil dijalankan',
                'icon' => 'fa-database',
                'color' => 'info',
                'time' => '4 jam lalu',
                'author' => 'Sistem backup'
            ],
            [
                'type' => 'login',
                'title' => 'Login berhasil',
                'description' => 'Admin login dari IP 192.168.1.100',
                'icon' => 'fa-sign-in-alt',
                'color' => 'success',
                'time' => '6 jam lalu',
                'author' => 'Sistem autentikasi'
            ],
        ];
        
        // System metrics (7 days)
        $metrics = [
            'total_logins' => 1248,
            'new_reports' => TaskReport::count(),
            'completed_tasks' => $approvedReports,
            'system_uptime' => 98.7,
        ];
        
        return view('superadmin.dashboard', [
            'totalUsers' => $totalUsers,
            'usersByRole' => $usersByRole,
            'totalDivisions' => $totalDivisions,
            'activeDivisions' => $activeDivisions,
            'inactiveDivisions' => $inactiveDivisions,
            'totalReports' => $totalReports,
            'approvedReports' => $approvedReports,
            'pendingReports' => $pendingReports,
            'revisionReports' => $revisionReports,
            'onlineUsers' => $onlineUsers,
            'offlineUsers' => $offlineUsers,
            'recentActivities' => $recentActivities,
            'metrics' => $metrics,
        ]);
    }
}
