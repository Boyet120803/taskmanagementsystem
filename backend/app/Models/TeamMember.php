<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class TeamMember extends Model
{
    protected $fillable = [
        'manager_id',
        'user_id',
    ];

    public function manager() {
        return $this->belongsTo(User::class, 'manager_id');
    }
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
