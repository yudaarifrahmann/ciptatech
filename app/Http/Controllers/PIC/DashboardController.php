<?php

namespace App\Http\Controllers\PIC;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskReport;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $stats = [
            'aktif' => TaskReport::where('user_id', $userId)
                        ->whereIn('status', ['progress', 'menunggu review', 'revisi', 'perbaikan'])
                        ->count(),

            'review' => TaskReport::where('user_id', $userId)
                        ->where('status', 'menunggu review')
                        ->count(),

            'revisi' => TaskReport::where('user_id', $userId)
                        ->where('status', 'revisi')
                        ->count(),
        ];

        $reports = TaskReport::where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();

        return view('pic.dashboard', compact('stats', 'reports'));
    }
}
