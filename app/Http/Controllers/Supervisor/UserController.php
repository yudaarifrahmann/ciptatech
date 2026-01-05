<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Division;

class UserController extends Controller
{
    public function index()
    {
        $supervisor = Auth::user();

        $pics = User::where('role', 'PIC')
            ->where('division_id', $supervisor->division_id)
            ->latest()
            ->get();

        $totalPic   = $pics->count();
        $activePic  = $pics->where('status', 'active')->count();
        $inactivePic = $pics->where('status', 'inactive')->count();

        return view('supervisor.pic.index', compact(
            'pics',
            'totalPic',
            'activePic',
            'inactivePic'
        ));
    }

    public function create()
{
    $supervisor = Auth::user();
    $pics = User::where('role', 'PIC')
        ->where('division_id', $supervisor->division_id)
        ->latest()
        ->get();

    $divisions = Division::all();
    $totalPIC = $pics->count();
    $aktif    = $pics->where('status', 'active')->count();
    $nonaktif = $pics->where('status', 'inactive')->count();

    return view('supervisor.create_users', [
        'pics'      => $pics,
        'totalPIC'  => $totalPIC,
        'aktif'     => $aktif,
        'nonaktif'  => $nonaktif,
        'divisions' => $divisions,
    ]);
}

    public function store(Request $request)
    {
        $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => 'required|email|unique:users,email',
        'password'      => 'required|min:8',
        'division_id'   => 'required|exists:divisions,id',
    ]);

        User::create([
        'name'          => $request->name,
        'email'         => $request->email,
        'password'      => Hash::make($request->password),
        'role'          => 'PIC',
        'division_id'   => $request->division_id, 
        'status'        => 'active',
    ]);

        return redirect()->back()->with('success', 'PIC berhasil ditambahkan');
    }
}
