@extends('layouts.app')
@section('content')

    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-lg text-grey text-sm font-normal">
               <a href="/projects" 
                class="text-lg text-grey text-sm font-normal"
                style="text-decoration: none;"
                >
                All Announcements
                </a>  / {{ str_limit($project->title, 80) }}
            </p>
        </div>
    </header>

    <div class="lg:flex -mx-3">
        
        <div class="lg:w-3/4 px-3 mb-6">
            
            <div class="mb-10">
                <h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>


                @foreach($project->tasks as $task)
                    <div class="bg-white p-3 mb-3 card w-full">
                        <form method="POST" action="{{ $task->path() }}">
                            @method('PATCH')
                            @csrf
                            <div class="flex">
                                <input class="w-full {{ $task->completed ? 'text-grey' : ''}}" name="body" type="text" value="{{ $task->body }}">
                                <input type="checkbox" name="completed" onChange="this.form.submit()" {{ $task->completed ? 'checked' : ''}}>
                            </div>
                        </form>
                    </div>
                @endforeach

                <div class="bg-white p-3 mb-3 card w-full">
                    <form action="{{ $project->path().'/tasks'}}" method="POST">
                        @csrf
                        <input name="body" class="w-full" type="text" placeholder="Add a new task...">
                    </form>
                </div>
                
                @if ($errors->has('body'))
                    <span 
                        style="width: 100%; margin-top: .25rem; font-size: 80%; color: #e3342f;"
                        role="alert"
                    ><strong>{{ $errors->first('body') }}</strong>
                @endif

            </div>
            
            <div>
                <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>
                
                <!-- General notes -->

                <form class="text-right"  action="{{ $project->path() }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <textarea 
                        name="notes"
                        class="bg-white p-4 card w-full mb-4" 
                        style="min-height: 200px"
                        placeholder="Anything special that you want to make a note of?"
                    >{{ $project->notes }}</textarea>
                    <button type="submit" class="py-1 px-4 text-lg button rounded-full text-white is-link hover:bg-blue-dark border-2 border-blue">Save</button>
                </form>
            </div>

        </div>
        
        <div class="lg:w-1/4 px-3">
            <div class="bg-white p-5 card" >
                <h3 class="font-normal mb-3 text-xl py-2 -ml-12 border-l-4 border-blue-light pl-4">
                    <a style="text-decoration: none" class="text-black" href="{{ $project->path() }}/edit">{{ $project->title }} </a>
                </h3>
                <div class="text-grey">{{ str_limit($project->description, 100) }}</div>
            </div>
            @include('projects.activity.card')
        </div>
        
    </div>
@endsection 