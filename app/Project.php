<?php

namespace App;

use App\Activity;
use App\RecordActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    use RecordsActivity;

    protected $guarded = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo('App\User');
    }

    public function addTask($task)
    {
        return $this->tasks()->create($task);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('start');
    }
}
