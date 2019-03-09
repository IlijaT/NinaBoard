@extends('layouts.app')
@section('content')

    <main class="lg:flex">

        {{-- all projects - left side --}}
        <div class="lg:w-3/4 m-2 p-2">

            <div class="flex flex-column">

                <div class="flex m-2 items-end">
                    <h2 class="text-grey text-lg font-normal">
                        <i class="fas fa-bullhorn mr-2 text-2xl text-blue"></i>
                        Announcements
                    </h2>
                    {{-- button to add new announcement --}}
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
        <div class="lg:w-1/4 lg:flex flex-column ">

            {{-- Today's Tasks --}}
            <div class="mb-2">
                <div class="flex flex-column m-1 px-3 pt-3 pb-1 bg-white flex-1 h-full overflow-auto">
 
                    <h2 class="py-2 text-black text-lg font-bold">Today's Tasks</h2>

                    @forelse($tasks as $task)
                    <div>
                        <h3 class="text-black text-xs {{ $task->completed == '1' ? 'line-through text-green' : 'text-orange'}}">
                                
                            <span class="font-bold"> {{ $task->project->title }} </span> - 
                            <span class="text-xs italic"> "{{ $task->title }}" </span>
                            <span class="text-grey"> 
                                ({{ $task->start->hour }}:{{ $task->start->minute }} 
                                - {{ $task->end->hour }}:{{ $task->end->minute }}) 
                            </span>
                        </h3>
                    </div>
                    @empty
                        <div class="text-black text-normal px-1">
                            <div class="flex items-start">
                                <span>Easy day!</span>
                                <i class="fas fa-smile-wink text-xl text-yellow-dark ml-2"></i>
                            </div>
                        </div>
                    @endforelse
                
                </div>

            </div>

            {{-- latest updates --}}
            <div style="height:350px" class="my-1">

                <div class="flex flex-column m-1 p-3 bg-white flex-1 h-full overflow-auto">

                    <h2 class="py-2 text-black text-lg font-bold">Latest Updates</h2>
                    
                    @include('projects.activity.card')
                
                </div>
            </div>

        </div>

        
    </main>


 
@endsection