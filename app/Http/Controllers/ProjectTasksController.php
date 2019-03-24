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
            ['title' => 'required|max:190'],
            ['start' => 'required|date'],
            ['end' => 'required|date']
        );

        $task = $project->addTask(request(['title', 'start', 'end']));

        if (request()->ajax()) {
            return Task::with('activities.user', 'activities.subject')->find($task->id);
        }

        return redirect($project->path())->with('flash', [
            'message' => 'A new task has been created!',
            'color' => 'green'
            ]);
    }



    public function update(Project $project, Task $task)
    {
        $attributes = request()->validate(
            ['title' => 'required|max:190'],
            ['start' => 'required|date'],
            ['end' => 'required|date']
        );
        
        $task->update(request(['title', 'start', 'end']));

        if (request('completed')) {
            $task->complete();
        } else {
            $task->incomplete();
        }

        if (request()->ajax()) {
            return Task::with('activities.user', 'activities.subject')->find($task->id);
        }

        return redirect($project->path())->with('flash', [
            'message' => 'The task has been updated!',
            'color' => 'green'
            ]);
    }
}
