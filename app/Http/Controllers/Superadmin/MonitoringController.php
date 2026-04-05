<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class MonitoringController extends Controller
{
    public function index()
    {
        $total_users = User::count();
        $active_users = User::where('is_active', true)->count();
        $total_tasks = Task::count();
        
        $approved_tasks = Task::where('status', 'approved')->count();
        $completion_rate = $total_tasks > 0 ? round(($approved_tasks / $total_tasks) * 100, 1) : 0;

        $activities = Activity::with('causer')
            ->latest()
            ->paginate(15);

        return view('superadmin.monitoring.index', compact(
            'total_users',
            'active_users',
            'total_tasks',
            'completion_rate',
            'activities'
        ));
    }
}

