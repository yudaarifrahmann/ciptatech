<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TaskReport extends Model
{
    use HasFactory, \App\Traits\BelongsToOrganization;

    protected $table = 'task_reports';

    protected $fillable = [
        'user_id',
        'organization_id',
        'task_name',
        'description',
        'progress',
        'file_path',
        'video',
        'github_link',
        'status',
        'feedback',
        'revision_note',
    ];

    public function pic()
{
    return $this->belongsTo(User::class, 'user_id'); 
}
}
