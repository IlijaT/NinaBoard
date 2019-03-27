<?php

namespace App\Http\Controllers;

use App\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    // this method returns last 48h ativity for all projects
    public function index()
    {
        $activities = Activity::latest('updated_at')->with(['subject', 'user'])->where('updated_at', '>', Carbon::now()->subDays(2))
        ->get();
        
        return $activities;
    }
}
