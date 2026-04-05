<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer')->latest();

        // Filtering
        if ($request->filled('log_name') && $request->log_name != 'Semua Tipe') {
            $query->where('log_name', $request->log_name);
        }

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('user_id') && $request->user_id != 'Semua User') {
            $query->where('causer_id', $request->user_id);
        }

        $activities = $query->paginate(20)->withQueryString();
        $logNames = Activity::distinct()->pluck('log_name')->filter();
        $users = User::all();

        return view('superadmin.audit.index', compact('activities', 'logNames', 'users'));
    }
}
