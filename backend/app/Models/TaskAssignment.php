<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Task;
use App\Models\TeamMember;
class TaskAssignment extends Model
{
    protected $fillable = ['task_id', 'user_id','manager_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
    
  
}