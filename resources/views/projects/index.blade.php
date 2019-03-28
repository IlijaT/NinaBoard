@extends('layouts.app')
@section('title', 'Announcements')
@section('content')

    <main class="lg:flex">

        {{-- all projects - left side --}}
        <div class="lg:w-3/4 m-2">

            <div class="flex flex-column">

                <div class="flex items-end">
                    <div class="text-grey text-sm font-normal">
                        Announcements
                    </div>
                    {{-- button to add new announcement --}}
                    <add-announcement class="ml-auto"></add-announcement>
                </div>
                
                <announcements :projects="{{ $projects }}">
                </announcements>

            </div>

        </div>


        {{-- right side --}}
        <div class="lg:w-1/4 lg:flex flex-column ">

            {{-- Today's Tasks --}}
            <today-tasks></today-tasks>

            {{-- latest 48h updates --}}
            <latest-activity></latest-activity>
            
            {{-- <div style="height:400px" class="my-1">

                <div class="flex flex-column m-1 p-3 bg-white flex-1 h-full overflow-auto">

                    <h2 class="py-2 text-black text-lg font-bold">Latest Updates</h2>
                    
                    @include('projects.activity.card')
                
                </div>
            </div> --}}

        </div>

        
    </main>


 
@endsection