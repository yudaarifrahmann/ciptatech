<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\FormSchema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormBuilderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $type = $request->get('type', 'weekly');
        
        // Ensure valid type
        if (!in_array($type, ['weekly', 'daily', 'submission'])) {
            $type = 'weekly';
        }

        $schema = FormSchema::where('division_id', $user->division_id)
            ->where('form_type', $type)
            ->first();

        return view('supervisor.form-builder.index', compact('schema', 'type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'form_type' => 'required|string|in:weekly,daily,submission',
            'fields' => 'nullable|array',
            'fields.*.label' => 'required_with:fields|string',
            'fields.*.type' => 'required_with:fields|string|in:text,number,date,file,textarea,select',
            'fields.*.required' => 'boolean',
        ]);

        $user = Auth::user();
        
        FormSchema::updateOrCreate(
            [
                'division_id' => $user->division_id, 
                'organization_id' => $user->organization_id,
                'form_type' => $request->form_type
            ],
            ['schema' => $request->fields ?? [], 'is_active' => true]
        );

        return redirect()->back()->with('success', 'Konfigurasi formulir berhasil disimpan!');
    }
}
