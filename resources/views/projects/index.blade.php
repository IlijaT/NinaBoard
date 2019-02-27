@extends('layouts.app')
@section('content')

    <main class="lg:flex">

        {{-- all projects - left side --}}
        <div class="lg:w-3/4 m-2 p-2">

            <div class="flex flex-column">

                <div class="flex m-2 items-center">
                    <h2 class="text-grey text-sm font-normal">Announcements</h2>
                    <a class="ml-auto text-normal button rounded-full text-white hover:no-underline hover:bg-blue-dark" href="/projects/create">Add New</a>
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


        {{-- latest updates - right side --}}
        <div class="lg:w-1/4 bg-grey-lightest ">
            <div class="flex flex-column h-full">
                <div class="mt-3 p-3">
                    <h2 class="text-grey text-lg text-xl">Latest Updates</h2>
                </div>

                @forelse($activities as $activity)
                <div class="mx-3">
                 <h2 class="text-grey text-sm font-normal">{{ $activity->description }}</h2>
                </div>
                @empty
                    <div class="mx-3">No Activity</div>
                @endforelse
                

            </div>
        </div>

        
    </main>


 
@endsection