<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TaskReport extends Model
{
    use HasFactory;

    protected $table = 'task_reports';

    protected $fillable = [
        'user_id',
        'task_name',
        'description',
        'progress',
        'file_path',
        'status',
        'feedback',
        'revision_note',
    ];

    public function pic()
{
    return $this->belongsTo(User::class, 'user_id'); 
}
}
