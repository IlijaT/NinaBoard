<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use Illuminate\Http\Request;
use App\Events\TaskCreated;
use App\Events\TaskUpdated;

class ProjectTasksController extends Controller
{
    public function index(Project $project)
    {
        return $project->tasks;
    }
    
    public function store(Project $project)
    {
        request()->validate(
            ['title' => 'required|max:190'],
            ['start' => 'required|date'],
            ['end' => 'required|date']
        );

        $task = $project->addTask(request(['title', 'start', 'end']));
        
        event(new TaskCreated($task, $task->activities()->with('user')->latest()->first()));

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

        event(new TaskUpdated($task, $task->activities()->with('user')->latest()->first()));

        if (request()->ajax()) {
            return Task::with('activities.user', 'activities.subject')->find($task->id);
        }

        return redirect($project->path())->with('flash', [
            'message' => 'The task has been updated!',
            'color' => 'green'
            ]);
    }
}
