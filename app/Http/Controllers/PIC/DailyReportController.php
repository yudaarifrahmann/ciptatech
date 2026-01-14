<?php

namespace App\Http\Controllers\Pic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyReport;

class DailyReportController extends Controller
{
    public function index()
    {
        return view('pic.daily-report');
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_date' => 'required|date',
            'task'        => 'required|string|max:255',
            'description' => 'required|string',
            'documentation' => 'nullable|image|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('documentation')) {
            $filePath = $request->file('documentation')->store('daily-report', 'public');
        }

        DailyReport::create([
            'user_id'      => auth()->id(),
            'report_date'  => $request->report_date,
            'task'         => $request->task,
            'description'  => $request->description,
            'documentation'=> $filePath,
        ]);

        return back()->with('success', 'Daily report berhasil disimpan');
    }
}
 