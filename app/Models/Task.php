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

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // Parent Task (child → parent)
    public function parent()
    {
        return $this->belongsTo(Task::class, 'task_group_id');
    }

    // Child Tasks (parent → children) ✅ REVERSE RELATION
    public function children()
    {
        return $this->hasMany(Task::class, 'task_group_id')
                    ->orderBy('task_order');
    }

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

    // Latest submission (clean & optimal)
    public function latestSubmission()
    {
        return $this->hasOne(TaskSubmission::class)->latestOfMany();
    }
}
