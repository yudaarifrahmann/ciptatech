<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyReport extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory, \App\Traits\BelongsToOrganization;

    protected $fillable = [
        'user_id',
        'organization_id',
        'report_date',
        'task',
        'description',
        'documentation',
        'video',
        'github_link',
        'additional_data',
    ];

    protected $casts = [
        'report_date' => 'date',
        'additional_data' => 'array',
    ];

    /**
     * Relasi ke user (PIC yang membuat laporan)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}