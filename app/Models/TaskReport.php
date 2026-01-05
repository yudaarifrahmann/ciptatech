<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskReport extends Model
{
    use HasFactory;

    protected $table = 'task_reports';

    protected $fillable = [
        'user_id',
        'task_name',
        'progress',
        'status',
        'file',
        'description'
    ];

    public function pic()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
