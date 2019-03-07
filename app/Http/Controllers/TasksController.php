<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

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

        return $task;
    }
}
