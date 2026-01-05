<?php
namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('superadmin.users.index', compact('users'));
    }

    public function create()
    {
        $divisions = Division::all();
        return view('superadmin.users.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'division_id' => $request->division_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        $divisions = Division::all();
        return view('superadmin.users.edit', compact('user', 'divisions'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'division_id' => $request->division_id,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6'
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('superadmin.users.index')
            ->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        $user->delete();
        
        return redirect()->route('superadmin.users.index')
            ->with('success', 'User berhasil dihapus');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil direset');
    }

    public function toggleStatus(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);

        return back()->with('success', 'Status user berhasil diubah');
    }
}