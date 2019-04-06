<?php

namespace App\Http\Controllers;

use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $tasks = Task::with('project')->where('start', '>', Carbon::now()->subWeeks(8))->get();
        return view('calendar', ['tasks' => $tasks]);
    }
}
