<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    use HasFactory, \App\Traits\BelongsToOrganization;

    protected $fillable = [
        'task_id',
        'pic_id',
        'status',
        'submission_notes',
        'submission_file',
        'additional_data',
        'submitted_at',
        'reviewed_at',
        'reviewer_feedback',
        'completed_tasks_count',
        'organization_id',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'additional_data' => 'array',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
}
