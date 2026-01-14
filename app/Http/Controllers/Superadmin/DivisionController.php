<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request; // Import ini wajib ditambahkan

class DivisionController extends Controller
{
    /**
     * Menampilkan daftar divisi.
     */
    public function index()
    {
        $divisions = Division::all();
        return view('superadmin.divisions.index', compact('divisions'));
    }

    /**
     * Menyimpan divisi baru ke database.
     */
    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required|unique:divisions,name'
        ]);

        Division::create($request->all());

        return redirect()->back()->with('success', 'Divisi berhasil ditambahkan');
    }

    /**
     * Memperbarui data divisi yang sudah ada.
     */
    public function update(Request $request, Division $division) 
    {
        $request->validate([
            'name' => 'required|unique:divisions,name,' . $division->id
        ]);

        $division->update($request->all());

        return redirect()->back()->with('success', 'Divisi berhasil diperbarui');
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