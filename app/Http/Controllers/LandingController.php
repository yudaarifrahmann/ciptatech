<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $stats = [
            'tasks_completed' => Task::where('status', 'selesai')->count(),
            'users' => User::where('is_active', 1)->count(), // Use is_active instead of status
            'divisions' => Division::count(),
        ];

        return view('landing', compact('stats'));
    }
}
