<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name', 'api', 'admin', 'invite'
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
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
