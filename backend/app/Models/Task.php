<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'assign_to',
    ];
 
       public function assignedUser()
        {
            return $this->belongsTo(User::class, 'assign_to');
        }

        public function manager()
        {
            return $this->belongsTo(User::class, 'assign_to');
        }
    

}
