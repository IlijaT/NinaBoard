<?php

namespace Tests\Setup;

use App\Task;
use App\User;
use App\Project;

class ProjectFactory 
{

    protected $taskCount = 0;
    protected $user;

    public function withTasks($count = 0) 
    
    {
        $this->taskCount = $count;

        return $this;
    
    }

    public function create() 
    
    {
        
        $project = factory(Project::class)->create([
            'owner_id' => auth()->id()
        ]);

        factory(Task::class, $this->taskCount)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }

    public function ownedBy($user)
    {
        $this->user = $user;
        return $this;
    }
}
