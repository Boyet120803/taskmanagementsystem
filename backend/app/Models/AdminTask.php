<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminTask extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'user_id',
    ];

   
}
