<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::latest('updated_at')->get();
        
        return view('projects.index', compact('projects'));
    }

    
    
    public function create()
    {
        return view('projects.create');
    }

    
    
    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'nullable'
        ]);
        
        $attributes['owner_id'] = auth()->id();
       
        $project = auth()->user()->projects()->create($attributes);

        
        return redirect($project->path())->with('flash', 'Your announcment has been created!');
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
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
        
        $project->update($attributes);

        return redirect($project->path())->with('flash', 'The announcment has been updated!');
        ;
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete-project', $project);
        $project->delete();

        return redirect('/projects')->with('flash', 'The announcment has been deleted!');
    }
}
