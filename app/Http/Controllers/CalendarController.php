<?php

namespace App\Http\Controllers;

use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $tasks = Task::with('project')->get()->where('start', '>', Carbon::now()->subWeeks(4));
        
        return view('calendar', compact('tasks'));
    }
}
