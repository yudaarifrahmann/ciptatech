<?php
namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with(['division', 'latestSubmission.pic']);

        // Filtering
        if ($request->filled('division_id') && $request->division_id != 'Semua Divisi') {
            $query->where('division_id', $request->division_id);
        }

        if ($request->filled('status') && $request->status != 'Semua Status') {
            $statusMap = [
                'Disetujui' => 'approved',
                'Menunggu Review' => 'submitted',
                'Revisi' => 'rejected', // Assuming Revisi means rejected or a specific state
                'Ditolak' => 'rejected',
            ];
            
            $status = $statusMap[$request->status] ?? null;
            if ($status) {
                $query->where('status', $status);
            }
        }

        if ($request->filled('pic_id') && $request->pic_id != 'Semua PIC') {
            $query->whereHas('submissions', function ($q) use ($request) {
                $q->where('pic_id', $request->pic_id);
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $tasks = $query->latest()->paginate($request->input('per_page', 10))->withQueryString();

        // Stats calculation
        $total_reports = Task::count();
        $approved_count = Task::where('status', 'approved')->count();
        $pending_count = Task::whereIn('status', ['submitted', 'in_progress'])->count();
        
        // Avg Response Time (Days) - based on submitted_at and reviewed_at
        $avg_response_time = 0;
        $reviewedSubmissions = DB::table('task_submissions')
            ->whereNotNull('submitted_at')
            ->whereNotNull('reviewed_at')
            ->select(DB::raw('AVG(TIMESTAMPDIFF(DAY, submitted_at, reviewed_at)) as avg_days'))
            ->first();
        
        if ($reviewedSubmissions && $reviewedSubmissions->avg_days !== null) {
            $avg_response_time = round($reviewedSubmissions->avg_days, 1);
        }

        $divisions = Division::all();
        $pics = User::where('role', 'PIC')->get();

        return view('supervisor.reports', compact(
            'tasks', 
            'total_reports', 
            'approved_count', 
            'pending_count', 
            'avg_response_time',
            'divisions',
            'pics'
        ));
    }
}
