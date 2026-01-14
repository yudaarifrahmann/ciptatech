<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyReport extends Model
{
    protected $fillable = [
        'user_id',
        'report_date',
        'task',
        'description',
        'documentation',
    ];

    /**
     * Relasi ke user (PIC yang membuat laporan)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}