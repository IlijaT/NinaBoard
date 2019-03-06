@extends('layouts.app')
@section('content')

<div class="lg:flex -mx-3 items-start mb-3 -mt-2">

    {{-- left side --}}
    <div class="lg:w-3/4  py-4 justify-between items-end w-full">
        
        <header class="flex items-center px-2">
            <div class="flex justify-between items-end w-full">
                    
                <p class="text-grey text-normal font-normal">
                       
                    <a href="/projects" 
                    class="hover:no-underline hover:text-blue text-lg text-grey-dark font-normal"
                    >
                    <i class="fab fa-earlybirds text-2xl text-blue mr-2"></i>
                    All Announcements
                    </a>  / 
                    <span  
                    class="text-normal text-grey text-lg font-normal"> {{ str_limit($project->title, 80) }}
                    </span>
                </p>
                
            </div>
        </header>

        <div class="lg:flex items-start mb-3 mr-2">
           
            {{-- left side of  left side --}}
            <div class="lg:w-3/5 mb-6 mx-2">
                <div class="mb-10">
                    <h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>
    
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
    

                    {{-- add task modal --}}
                    <add-task class="mt-5" :project="{{ $project }}"></add-task>
                    
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
                            class="bg-white p-4 card w-full mb-3" 
                            style="min-height: 200px"
                            placeholder="Anything special that you want to make a note of?"
                        >{{ $project->notes }}</textarea>
                        <button type="submit" class="py-1 px-3 text-lg button rounded-full text-white is-link hover:bg-blue-dark">Add Note</button>
                    </form>
                </div>
                

            </div>
        
            {{-- rigt side of left side --}}
            <div class="lg:w-2/5 mt-3 mx-2">
                <div class="bg-white mt-3 card" >
                    <h3 class="font-normal mt-4 px-3 py-2 text-lg border-l-4 border-blue-light">
                        <a class="text-black hover:no-underline hover:text-blue" href="{{ $project->path() }}/edit">{{ $project->title }} </a>
                    </h3>
                    {{-- <div class="text-grey text-xs py-3 px-4 ">{!! nl2br(preg_replace('/^[ \t]*[\r\n]+/m', '', $project->description))  !!}</div> --}}
                    <div class="text-grey text-xs py-3 px-4 ">{!! nl2br($project->description)  !!}</div>

                </div>
            </div>
        </div>

    </div>

    {{-- rigt side --}}
    <div class="lg:w-1/4">
        <div class="bg-grey-lightest py-4 px-2">
            <h2 class="text-grey-dark text-lg text-xl">Latest Updates</h2>
            <ul class="text-xs list-reset">
                @if(isset($activities))
                    @foreach($activities as $activity)
                        <li class="{{$loop->last ? '' : 'mb-1'}}">
                            @include("projects.activity.{$activity->description}")
                            <span class="text-grey">{{ $activity->created_at->diffForHumans() }}</span>
                        </li>
                    @endforeach
                @else
                @foreach($project->activities as $activity)
                    <li class="{{$loop->last ? '' : 'mb-1'}}">
                        @include("projects.activity.{$activity->description}")
                        <span class="text-grey">{{ $activity->created_at->diffForHumans() }}</span>
                    </li>
                @endforeach
                @endif
            </ul>
        </div>
    </div>

</div>
@endsection 