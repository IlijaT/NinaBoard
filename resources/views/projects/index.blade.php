@extends('layouts.app')
@section('content')

    <main class="lg:flex">

        {{-- all projects - left side --}}
        <div class="lg:w-3/4 m-2 p-2">

            <div class="flex flex-column">

                <div class="flex m-2 items-center">
                    <h2 class="text-grey text-lg font-normal">
                        <i class="fas fa-bullhorn mr-2 text-2xl text-blue"></i>
                        Announcements
                    </h2>
                    {{-- <a class=" bg-blue ml-auto text-normal btn rounded-full text-white hover:no-underline hover:bg-blue-dark" @click="$modal.show('AddAnnouncement')">Add New</a> --}}
                    <add-announcement class="ml-auto"></add-announcement>
                </div>

                <div class="lg:flex lg:flex-wrap mt-4 -mx-3">
                    @forelse($projects as $project)
                        <div class="lg:w-1/3 px-3 pb-6">
                            @include('projects.card')
                        </div>
                    @empty
                        <div>No Announcements Yet</div>
                    @endforelse
                </div>

            </div>

        </div>


        {{-- right side --}}
        <div class="lg:w-1/4 lg:flex flex-column -mt-3">

            {{-- Today's Tasks --}}
            <div class="h-64 mb-1 p-1 ">
                <div class="flex flex-column mb-1 bg-white flex-1 h-full overflow-auto">

                    <div class="p-3">
                        <h2 class="text-grey-dark text-lg">Today's Tasks</h2>
                    </div>

                    @forelse($tasks as $task)
                    <div class="mx-1">
                        <h3 class="text-black text-xs px-1 {{ $task->completed == '1' ? 'line-through text-purple-dark' : 'text-green-dark'}}">
                                
                            <span class="font-bold"> {{ $task->project->title }} </span> - 
                            <span class="text-xs italic"> "{{ $task->title }}" </span>
                            <span class="text-grey"> 
                                ({{ $task->start->hour }}:{{ $task->start->minute }} 
                                - {{ $task->end->hour }}:{{ $task->end->minute }}) 
                            </span>
                        </h3>
                    </div>
                    @empty
                        <div class="1">
                            <h2 class="text-black text-sm ">Easy day!</h2>
                        </div>
                    @endforelse
                
                </div>

            </div>

            {{-- latest updates --}}
            <div class="p-1 h-64 overflow-auto">

                <div class="flex flex-column bg-white flex-1">

                    <div class="mt-1">
                        <h2 class="text-grey-dark text-lg text-xl">Latest Updates</h2>
                    </div>
                    
                    @include('projects.activity.card')
                
                
                </div>
            </div>

        </div>

        
    </main>


 
@endsection