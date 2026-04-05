<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DivisionController extends Controller
{
    /**
     * Menampilkan daftar divisi.
     */
    public function index()
    {
        $divisions = Division::with('supervisors')->get();
        $supervisors = \App\Models\User::where('role', 'supervisor')->get();
        return view('superadmin.divisions.index', compact('divisions', 'supervisors'));
    }

    /**
     * Menyimpan divisi baru ke database.
     */
    public function store(Request $request) 
    {
        $user = auth()->user();
        $request->validate([
            'name' => [
                'required',
                Rule::unique('divisions')->where(fn ($query) => $query->where('organization_id', $user->organization_id))
            ],
            'supervisor_ids' => 'nullable|array',
            'supervisor_ids.*' => 'exists:users,id'
        ]);

        $division = Division::create($request->only(['name', 'description', 'is_active']));

        if ($request->has('supervisor_ids')) {
            \App\Models\User::whereIn('id', $request->supervisor_ids)
                ->where('role', 'supervisor')
                ->update(['division_id' => $division->id]);
        }

        return redirect()->back()->with('success', 'Divisi berhasil ditambahkan');
    }

    /**
     * Memperbarui data divisi yang sudah ada.
     */
    public function update(Request $request, Division $division) 
    {
        $user = auth()->user();
        $request->validate([
            'name' => [
                'required',
                Rule::unique('divisions')->ignore($division->id)->where(fn ($query) => $query->where('organization_id', $user->organization_id))
            ],
            'supervisor_ids' => 'nullable|array',
            'supervisor_ids.*' => 'exists:users,id'
        ]);

        $division->update($request->only(['name', 'description', 'is_active']));

        // Reset all currently assigned supervisors for this division
        \App\Models\User::where('division_id', $division->id)
            ->where('role', 'supervisor')
            ->update(['division_id' => null]);

        // Assign selected supervisors
        if ($request->has('supervisor_ids')) {
            \App\Models\User::whereIn('id', $request->supervisor_ids)
                ->where('role', 'supervisor')
                ->update(['division_id' => $division->id]);
        }

        return redirect()->back()->with('success', 'Divisi dan penugasan supervisor berhasil diperbarui');
    }

    /**
     * Menghapus data divisi dari database.
     */
    public function destroy(Division $division) 
    {
        $division->delete();
        
        return redirect()->back()->with('success', 'Divisi berhasil dihapus');
    }
}