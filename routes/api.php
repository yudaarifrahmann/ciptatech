<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;

Route::middleware('auth')->get('/notifications', function (Request $request) {
    $user = $request->user();
    $notifications = $user->notifications()->latest()->take(20)->get()->map(function($n) use ($user) {
        return [
            'id' => $n->id,
            'data' => $n->data,
            'read_at' => $n->read_at,
            'created_at' => $n->created_at,
            'role' => $user->role,
        ];
    });

    return response()->json($notifications);
});
