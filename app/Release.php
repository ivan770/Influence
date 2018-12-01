<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    protected $fillable = [
        'name', 'description', 'type', 'user_id', 'url'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
