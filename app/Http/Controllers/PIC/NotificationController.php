<?php

namespace App\Http\Controllers\PIC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->latest()->take(50)->get();

        return view('pic.notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request, $id)
    {
        $user = auth()->user();
        $notification = $user->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }

        return back();
    }

    public function markAllRead(Request $request)
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();
        return back();
    }
}
