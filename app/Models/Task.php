<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'division_id',
        'supervisor_id',
        'title',
        'task_item_title',
        'description',
        'deadline',
        'status',
        'task_group_id',
        'task_order',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }

    public function getLatestSubmission()
    {
        return $this->submissions()->latest()->first();
    }
}
