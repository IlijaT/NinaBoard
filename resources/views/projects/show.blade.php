@extends('layouts.app')
@section('content')

<div class="lg:flex -mx-3 items-start">

    {{-- left side --}}
    <div class="lg:w-3/4 justify-between items-end w-full">

        <div class="lg:flex items-start my-1 mb-3 mr-2">
           
            {{-- left side of  left side --}}
            <div class="lg:w-3/5 mx-2 ">
                <div class="mb-10">

                    <div class="flex items-center">
                        <div class="flex pt-2 justify-between items-end w-full">
                                
                            <div class="text-grey text-sm font-normal ">
                                <a href="/projects" 
                                class="hover:no-underline hover:text-blue text-sm text-grey-dark font-normal"
                                >
                                All Announcements
                                </a>  / 
                                <span  
                                class="text-sm text-grey font-normal"> {{ str_limit($project->title, 80) }}
                                </span>
                            </div>

                            {{-- add task modal --}}
                            <add-task :project="{{ $project }}"></add-task>
                        </div>
                            
                        </div>

                    <h2 class="text-sm text-grey font-normal my-3">Tasks</h2>
    
                    {{-- show tasks --}}
                    @foreach($project->tasks as $task)
                        <div class="bg-white p-3 mb-2 card w-full">
                            <form method="POST" action="{{ $task->path() }}">
                                @method('PATCH')
                                @csrf
                                <div class="flex">
                                    <input class="w-full {{ $task->completed ? 'text-grey' : ''}}" name="title" type="text" value="{{ $task->title }}">
                                    <input type="checkbox" name="completed" onChange="this.form.submit()" {{ $task->completed ? 'checked' : ''}}>
                                </div>
                            </form>
                        </div>
                    @endforeach
    
                    @if ($errors->has('body'))
                        <span 
                            style="width: 100%; margin-top: .25rem; font-size: 80%; color: #e3342f;"
                            role="alert"
                        ><strong>{{ $errors->first('body') }}</strong>
                    @endif
        
                </div>

                <div>
                    <h2 class="text-sm text-grey font-normal my-3">General Notes</h2>
                    
                    <!-- General notes -->
                    <general-notes :project="{{ $project }}"></general-notes>

                </div>
                

            </div>
        
            {{-- rigt side of left side --}}
            <project-card :project="{{ $project }}"></project-card>

        </div>

    </div>

    {{-- rigt side --}}
    <div class="lg:w-1/4">
        <div  class="flex flex-column mb-2 mx-0 my-1 p-3 bg-white">
            <h2 class="py-2 text-black text-lg font-bold">Latest Tasks Updates</h2>
            <latest-project-updates :project="{{ $project->activities()->with(['subject', 'user'])->get() }}"></latest-project-updates>
            {{-- @include("projects.activity.card") --}}

        </div>

    </div>

</div>
@endsection 