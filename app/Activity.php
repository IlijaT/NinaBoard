<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    protected $casts = [
        'changes' => 'array'
    ];

    public function subject()
    {
        return $this->morphTo()->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class)->withTrashed();
    }
}
