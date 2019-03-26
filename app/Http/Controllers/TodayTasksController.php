<?php

namespace App\Http\Controllers;

use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TodayTasksController extends Controller
{
    public function index()
    {
        $tasks = Task::whereDate('start', Carbon::today())->latest('created_at')->with('project')->get();

        return $tasks;
    }
}
