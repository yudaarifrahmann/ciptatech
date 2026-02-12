<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\GenericNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->latest()->take(50)->get();

        // also fetch notifications created/sent by this superadmin (group by title+message)
        $created = \Illuminate\Support\Facades\DB::table('notifications')
            ->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(data,'$.title')) as title, JSON_UNQUOTE(JSON_EXTRACT(data,'$.message')) as message, MIN(created_at) as created_at")
            ->whereRaw("JSON_EXTRACT(data,'$.sender_id') = ?", [$user->id])
            ->groupBy('title','message')
            ->orderByDesc('created_at')
            ->get();

        return view('superadmin.notifications.index', compact('notifications', 'created'));
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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'roles' => 'required|array',
        ]);

        $roles = $request->input('roles', []);

        $targets = User::whereIn('role', $roles)->get();

        foreach ($targets as $user) {
            $user->notify(new GenericNotification($request->title, $request->message, auth()->user()));
        }

        activity()->causedBy(auth()->user())->withProperties(['roles' => $roles])->log('Kirim notifikasi massal');

        return back()->with('success', 'Notifikasi berhasil dikirim');
    }
}
