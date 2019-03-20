<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectActivityController extends Controller
{
    public function show(Project $project)
    {
        $activity = $project->activities()->with(['subject', 'user'])->get();
        return $activity;
    }
}
