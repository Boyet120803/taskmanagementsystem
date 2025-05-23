<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'gender',
        'address',
        'contact',
        'birthdate',
        'age',
        'image',
        'email',
        'password',
        'role',
    ];

      public function tasks()
      {
          return $this->hasMany(AdminTask::class);  
      }
 
      public function teamMembers() {
        return $this->hasMany(TeamMember::class, 'manager_id');
    }
    
        public function assignedTeam() {
            return $this->hasOne(TeamMember::class, 'user_id');
        }

        public function teamMembership()
        {
            return $this->hasOne(TeamMember::class, 'user_id');
        }
        public function taskAssignments()
        {
            return $this->hasMany(TaskAssignment::class, 'user_id'); 
        }

        public function taskSubmissions()
        {
            return $this->hasMany(TaskSubmission::class);
        }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
