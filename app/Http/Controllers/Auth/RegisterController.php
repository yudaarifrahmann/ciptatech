<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register-superadmin');
    }

    public function register(Request $request)
    {
        $request->validate([
            'organization_name' => ['required', 'string', 'max:255', 'unique:organizations,name'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        try {
            DB::beginTransaction();

            $organization = Organization::create([
                'name' => $request->organization_name,
                'slug' => Str::slug($request->organization_name),
                'is_active' => true,
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'superadmin',
                'organization_id' => $organization->id,
                'is_active' => true,
            ]);

            DB::commit();

            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Registrasi Berhasil! Selamat datang di Ciptatech.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}
