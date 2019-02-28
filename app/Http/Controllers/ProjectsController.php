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

        $activities = Activity::latest('updated_at')->limit(20)->get();

        $tasks = Task::whereDate('start', Carbon::today())->get();
        
        return view('projects.index', compact(['projects', 'activities', 'tasks']));
    }

    
    
    public function create()
    {
        return view('projects.create');
    }

    
    
    public function store()
    {
        Log::info(request());
        
        $attributes = request()->validate([
            'title' => 'required|max:190',
            'description' => 'required',
            'notes' => 'nullable'
        ]);
        
        $attributes['owner_id'] = auth()->id();
       
        $project = auth()->user()->projects()->create($attributes);

        
        return redirect($project->path())->with('flash', [
            'message' => 'Your announcement has been created!',
            'color' => 'green'
            ]);
    }

    
    
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    
    
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }



    public function update(Project $project)
    {
        $attributes = request()->validate([
            'title' => 'sometimes|required|max:190',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
        
        $project->update($attributes);

        return redirect($project->path())->with('flash', [
            'message' => 'The announcement has been updated!',
            'color' => 'green'
            ]);
        ;
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
