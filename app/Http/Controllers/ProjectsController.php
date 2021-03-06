<?php

namespace App\Http\Controllers;

use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Events\ProjectCreated;
use App\Events\ProjectUpdated;
use App\Events\ProjectSoftDeleted;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::latest('updated_at')->with('tasks')->get();

        return view('projects.index', compact('projects'));
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

        event(new ProjectCreated($project, $project->activities()->with('user')->latest()->first()));
    
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

        event(new ProjectUpdated($project, $project->tasks, $project->activities()->with('user')->latest()->first()));


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

        event(new ProjectSoftDeleted($project));

        $project->tasks()->delete();

        if (request()->ajax()) {
            return response()
            ->json(['data' => [], 'message' => 'The announcement has been deleted!']);
        }

        return redirect('/projects')->with('flash', [
            'message' => 'The announcement has been deleted!',
            'color' => 'orange'
            ]);
    }
}
