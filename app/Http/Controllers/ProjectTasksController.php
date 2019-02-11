<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        request()->validate(
            ['body' => 'required']
        );
        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {
        request()->validate(
            ['body' => 'required']
        );
        
        $task->update([
            'body' => request('body'),
            'completed' => request()->has('completed')
        ]);

        return redirect($project->path());
    }
}
