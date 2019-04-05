<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Events\TaskUpdated;

class TasksController extends Controller
{
 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Task $task)
    {
        $attributes = request()->validate(
            ['completed' => 'required']
        );

        if (request('completed')) {
            $task->complete();
        } else {
            $task->incomplete();
        }

        event(new TaskUpdated($task, $task->activities()->with('user')->latest()->first()));

        if (request()->ajax()) {
            return Task::with('project', 'activities.user', 'activities.subject')->find($task->id);
        }

        return $task;
    }
}
