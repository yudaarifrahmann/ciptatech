<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSchema extends Model
{
    use HasFactory, \App\Traits\BelongsToOrganization;

    protected $fillable = [
        'organization_id',
        'division_id',
        'form_type',
        'schema',
        'is_active',
    ];

    protected $casts = [
        'schema' => 'array',
        'is_active' => 'boolean',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
