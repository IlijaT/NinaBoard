@extends('layouts.app')
@section('content')

    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-lg text-grey text-sm font-normal">
               <a href="/projects" 
                class="text-lg text-grey text-sm font-normal"
                style="text-decoration: none;"
                >
                My Projects
                </a>  / {{ $project->title }}
            </p>
            <a class="text-lg button text-white" style="text-decoration: none;" href="/projects/create">New Project</a>
        </div>
    </header>

    <div class="lg:flex -mx-3">
        
        <div class="lg:w-3/4 px-3 mb-6">

            <div class="mb-10">
                <h2 class="text-grey font-normal mb-3">Tasks</h2>
                <!-- tasks -->
                <div class="bg-white p-3 card mb-3">OVDE IDU TASKOVi...</div>
                <div class="bg-white p-3 card mb-3">OVDE IDU TASKOVi...</div>
                <div class="bg-white p-3 card mb-3">OVDE IDU TASKOVi...</div>
                <div class="bg-white p-3 card mb-3">OVDE IDU TASKOVi...</div>
                <div class="bg-white p-3 card">OVDE IDU TASKOVi...</div>
            </div>
            
            <div>
                <h2 class="text-grey font-normal mb-3">General Notes</h2>
                <!-- General notes -->
                <textarea class="bg-white p-5 card w-full" style="min-height: 200px">Lorem ipsum...</textarea>
            </div>

        </div>
        
        <div class="lg:w-1/4 px-3">
            @include('projects.card')
        </div>

    </div>
@endsection 