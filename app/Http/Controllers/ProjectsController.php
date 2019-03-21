<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use App\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::latest('updated_at')->get();

        //$activities = Activity::latest('updated_at')->limit(5)->get();
        $activities = Activity::latest('updated_at')->where('updated_at', '>', Carbon::now()->subDays(2))
        ->get();


        $tasks = Task::whereDate('start', Carbon::today())->get();
        
        return view('projects.index', compact(['projects', 'activities', 'tasks']));
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required|max:190',
            'description' => 'required',
            'notes' => 'nullable'
        ]);
        
        $attributes['owner_id'] = auth()->id();
       
        $project = auth()->user()->projects()->create($attributes);
    
        return compact('project');
    }

    
    
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function update(Project $project)
    {
        $attributes = request()->validate([
            'title' => 'sometimes|required|max:190',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
        
        $project->update($attributes);

        if (request()->ajax()) {
            return Project::with('activities.user', 'activities.subject')->find($project->id);
        }
        
        return redirect($project->path())->with('flash', [
            'message' => 'The announcement has been updated!',
            'color' => 'green'
        ]);
    }

    public function destroy(Project $project)
    {
        if (! auth()->user()->hasRole('manager')) {
            abort(403);
        }
        
        $project->delete();

        return redirect('/projects')->with('flash', [
            'message' => 'The announcement has been deleted!',
            'color' => 'orange'
            ]);
    }
}
