<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST PIC (DIVISI SUPERVISOR)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $supervisor = Auth::user();

        $pics = User::where('role', 'PIC')
            ->where('division_id', $supervisor->division_id)
            ->latest()
            ->get();

        return view('supervisor.pic.index', [
            'pics' => $pics,
            'totalPic' => $pics->count(),
            'activePic' => $pics->where('status', 'active')->count(),
            'inactivePic' => $pics->where('status', 'inactive')->count(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | FORM CREATE PIC
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $supervisor = Auth::user();

        $pics = User::where('role', 'PIC')
            ->where('division_id', $supervisor->division_id)
            ->latest()
            ->get();

        return view('supervisor.create_users', [
            'pics'      => $pics,
            'divisions' => Division::all(),
            'totalPIC'  => $pics->count(),
            'aktif'     => $pics->where('status', 'active')->count(),
            'nonaktif'  => $pics->where('status', 'inactive')->count(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE PIC
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:8',
            'division_id' => 'required|exists:divisions,id',
        ]);

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => 'PIC',
            'division_id' => $request->division_id,
            'status'      => 'active',
            'is_active'   => true,
        ]);

        return redirect()
            ->back()
            ->with('success', 'PIC berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS PIC (OPTIONAL)
    |--------------------------------------------------------------------------
    */
    public function toggleStatus(User $user)
    {
        if ($user->role !== 'PIC') {
            abort(403);
        }

        $user->update([
            'status' => $user->status === 'active' ? 'inactive' : 'active',
            'is_active' => !$user->is_active,
        ]);

        return back()->with('success', 'Status PIC berhasil diperbarui');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE PIC (OPTIONAL)
    |--------------------------------------------------------------------------
    */
    public function destroy(User $user)
    {
        if ($user->role !== 'PIC') {
            abort(403);
        }

        $user->delete();

        return back()->with('success', 'PIC berhasil dihapus');
    }
}
