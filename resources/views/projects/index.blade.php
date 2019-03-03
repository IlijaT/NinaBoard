@extends('layouts.app')
@section('content')

    <main class="lg:flex">

        {{-- all projects - left side --}}
        <div class="lg:w-3/4 m-2 p-2">

            <div class="flex flex-column">

                <div class="flex m-2 items-center">
                    <h2 class="text-grey text-sm font-normal">Announcements</h2>
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
        <div class="lg:w-1/4 lg:flex flex-column">

            {{-- Today's Tasks --}}
            <div class="shadow-md flex-1 mb-1 p-1">
                <div class="flex flex-column mb-1 bg-grey-lightest flex-2 h-full">

                    <div class="mt-3 p-3">
                        <h2 class="text-grey-dark text-lg text-xl">Today's Tasks</h2>
                    </div>

                    @forelse($tasks as $task)
                    <div class="mx-3">
                        <h2 class="text-black text-sm ">
                            {{ $task->project->title }} {{ $task->title}} ({{ $task->start }} - {{ $task->end }}) </h2>
                    </div>
                    @empty
                        <div class="mx-3">
                            <h2 class="text-black text-sm ">Easy day!</h2>
                        </div>
                    @endforelse
                
                </div>

            </div>

            {{-- latest updates --}}
            <div class="shadow-md flex-1 p-1">

                <div class="flex flex-column bg-grey-lightest flex-1 h-full">

                    <div class="mt-1">
                        <h2 class="text-grey-dark text-lg text-xl">Latest Updates</h2>
                    </div>
                    
                    @include('projects.activity.card')
                    {{-- @forelse($activities as $activity)
                    <div class="mx-3">
                        <h2 class="text-grey text-sm font-normal">{{ $activity->description }}</h2>
                    </div> --}}
                    {{-- @empty
                        <div class="mx-3">No Activity</div>
                    @endforelse --}}
                
                </div>
            </div>

        </div>

        
    </main>


 
@endsection