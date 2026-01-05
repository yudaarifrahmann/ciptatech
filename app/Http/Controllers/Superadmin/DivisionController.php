<?php
namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Division;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::all();
        return view('superadmin.divisions.index', compact('divisions'));
    }
}
