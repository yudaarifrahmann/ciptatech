<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyReportController extends Controller
{
    public function index()
    {
        $supervisor = Auth::user();
        
        // PERBAIKI: Gunakan is_active bukan status
        $picUsers = User::where('role', 'PIC')
            ->where('division_id', $supervisor->division_id)
            ->where('is_active', 1) // ✅ Gunakan is_active
            ->pluck('id');
        
        // Jika divisi supervisor null atau tidak ada PIC
        if (!$supervisor->division_id || $picUsers->isEmpty()) {
            $dailyReports = collect();
            $todayReports = 0;
            $yesterdayReports = 0;
            $totalReports = 0;
        } else {
            // Ambil daily reports
            $dailyReports = DailyReport::with(['user' => function($query) {
                $query->with('division');
            }])
                ->whereIn('user_id', $picUsers)
                ->orderBy('report_date', 'desc')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            
            // Hitung statistik
            $totalReports = $dailyReports->total();
            $today = now()->toDateString();
            $yesterday = now()->subDay()->toDateString();
            
            $todayReports = DailyReport::whereIn('user_id', $picUsers)
                ->whereDate('report_date', $today)
                ->count();
                
            $yesterdayReports = DailyReport::whereIn('user_id', $picUsers)
                ->whereDate('report_date', $yesterday)
                ->count();
        }
        
        // Hitung jumlah PIC aktif - PERBAIKI
        $activePICCount = User::where('role', 'PIC')
            ->where('division_id', $supervisor->division_id)
            ->where('is_active', 1) // ✅ Gunakan is_active
            ->count();
        
        return view('supervisor.daily-reports.index', compact(
            'dailyReports',
            'totalReports',
            'todayReports',
            'yesterdayReports',
            'activePICCount'
        ));
    }
    
    public function show(DailyReport $dailyReport)
    {
        $dailyReport->load(['user.division']);
        $supervisor = Auth::user();
        
        if ($dailyReport->user->division_id !== $supervisor->division_id) {
            abort(403, 'Anda tidak memiliki akses ke laporan ini');
        }
        
        return view('supervisor.daily-reports.show', compact('dailyReport'));
    }
}