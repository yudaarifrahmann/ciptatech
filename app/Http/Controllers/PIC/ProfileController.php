<?php

namespace App\Http\Controllers\Pic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $activities = Activity::where('causer_id', $user->id)
            ->latest()
            ->limit(10)
            ->get();

        return view('pic.profile', compact('user', 'activities'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        activity()
            ->causedBy($user)
            ->log('Update profile');

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini salah'
            ]);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        activity()
            ->causedBy(auth()->user())
            ->log('Ganti password');

        return back()->with('success', 'Password berhasil diubah');
    }

    public function toggle2FA()
    {
        $user = auth()->user();

        $user->update([
            'two_factor_enabled' => ! $user->two_factor_enabled
        ]);

        activity()
            ->causedBy($user)
            ->log('Toggle 2FA');

        return response()->json([
            'status' => $user->two_factor_enabled
        ]);
    }
}
