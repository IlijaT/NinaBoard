<?php

namespace Tests\Setup;

use App\Task;
use App\User;
use App\Project;

class ProjectFactory 
{

    protected $taskCount = 0;

    public function withTasks($count = 0) 
    
    {
        $this->taskCount = $count;

        return $this;
    
    }

    public function create() 
    
    {
        
        $project = factory(Project::class)->create([
            'owner_id' => factory(User::class)
        ]);

        factory(Task::class, $this->taskCount)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }
}
