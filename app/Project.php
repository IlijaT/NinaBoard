<?php

namespace App;

use App\Activity;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public $old = [];

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
        return $this->tasks()->create(['body' => $task]);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class)->latest();
    }


    public function recordActivity($description)
    {
        return $this->activities()->create([
            'description' => $description,
            'changes'     => $this->activityChanges($description)   
            ]);
    }

    public function activityChanges($description) 
    {   
        
        if( $description === 'updated_project'){
            
            return [
                'before' => array_except(array_diff($this->old, $this->getAttributes()), 'updated_at'),
                'after'  => array_except($this->getChanges(), 'updated_at')
            ];
        }
    
    }
}
