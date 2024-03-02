<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Projects;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function projects()
    {
        //return $this->hasMany(Projects::class, 'manager_id');
        if ($this->role === 'gerente') {
           return $this->hasMany(Projects::class, 'manager_id');
        } else {
            // Si el usuario es un desarrollador, obtener los proyectos donde es desarrollador
           return $this->belongsToMany(Projects::class, 'project_user' ,'user_id','project_id')->withPivot('user_id');
           //return $this->belongsToMany(Projects::class, 'project_user')->wherePivot('role', 'desarrollador');
           //return $this->belongsToMany(Projects::class, 'project_user')->withPivot('role')->wherePivot('role', 'desarrollador');
           //return $this->belongsToMany(Projects::class, 'project_user', 'user_id')->wherePivot('role', 'desarrollador');
          /* return $this->select('users.*', 'projects.*')
            ->join('project_user', 'users.id', '=', 'project_user.user_id')
            ->join('projects', 'project_user.project_id', '=', 'projects.id')
            ->where('users.role', '=', 'desarrollador')
            ->get();*/
           // return $this->belongsToMany(Projects::class, 'project_user')->withPivot('role')->wherePivot('role', 'desarrollador');
    }
        }
    }

