<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskReport extends Model
{
    protected $table = 'task_reports';

    public function pic()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}


