@extends('layouts.app')
@section('content')
    <header  class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-center w-full">
            <h2 class="text-grey text-sm font-normal">My Projects</h2>
            <a class="button text-white" href="/projects/create">New Project</a>
        </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                <div class="bg-white p-5 rounded-lg shadow-md" style="height: 200px">
                    <h3 class="font-normal mb-3 text-xl py-2 -ml-12 border-l-4 border-blue-light pl-4">
                        <a style="text-decoration: none" class="text-black" href="{{ $project->path() }}">{{ $project->title }} </a>
                    </h3>
                    <div class="text-grey">{{ str_limit($project->description, 100) }}</div>
                </div>
            </div>
        @empty
            <div>no projects yet</div>
        @endforelse
    </main>
 
@endsection