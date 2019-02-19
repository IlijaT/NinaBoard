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

        return redirect($project->path())->with('flash', 'A new task has been created!');
    }



    public function update(Project $project, Task $task)
    {
        $attributes = request()->validate(
            ['body' => 'required']
        );
        
        $task->update($attributes);

        if (request('completed')) {
            $task->complete();
        } else {
            $task->incomplete();
        }

        return redirect($project->path())->with('flash', 'The task has been updated!');
    }
}
