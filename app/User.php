<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function project()
    {
       return $this->belongsToMany(Project::class);
    }

    public function tasks()
    {
       return $this->hasMany(Task::class);
    }

    public function issues()
    {
       return $this->hasMany(Issue::class);
    }

    public function releases()
    {
       return $this->hasMany(Release::class);
    }

    public function messages()
    {
       return $this->hasMany(Message::class);
    }
}
