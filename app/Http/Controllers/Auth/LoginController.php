<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required', 'min:6'],
    ]);

    if (!Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()
            ->withErrors(['email' => 'Email atau password tidak valid'])
            ->withInput($request->only('email')); 
    }

    $request->session()->regenerate();

    /** @var \App\Models\User $user */
    $user = Auth::user();

    return match ($user->role) {
        'superadmin' => redirect()->intended('/superadmin'),
        'supervisor' => redirect()->intended('/supervisor'),
        'PIC'        => redirect()->intended('/pic'),
        default      => redirect()->intended('/'),
    };
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
