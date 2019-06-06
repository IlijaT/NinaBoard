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
                    <div class="ml-auto flex content-center items-center">
                        <search-bar class="mr-3"></search-bar>
                        <add-announcement 
                            text='Add New' 
                            prop-style="bg-blue ml-auto btn rounded-lg text-white hover:bg-blue-dark" id="new-announcement-button">
                        </add-announcement>
                    </div>
                </div>
                
                <announcements :projects="{{ $projects }}"></announcements>

            </div>

        </div>

        {{-- right side --}}
        <div class="lg:w-1/4 lg:flex flex-column ">

            {{-- Today's Tasks --}}
            <today-tasks></today-tasks>

            {{-- latest 48h updates --}}
            <latest-activity></latest-activity>
            
        </div>
      
        <visible when-hidden="#new-announcement-button">
            <template slot="default" slot-scope="slotProps">
                <add-announcement 
                    style="position: fixed; right: 1em; bottom: 0;"
                    prop-style="bg-blue hover:bg-blue-dark rounded-full w-16 h-16 text-white text-4xl z-10 mr-8 mb-8
                    text-center flex items-center justify-center shadow-lg"
                    text='+' 
                     ></add-announcement>
            </template>
        </visible>

        <visible when-hidden="#visible-navbar">
            <template slot="default" slot-scope="slotProps">
                <div 
                style="position: fixed; top: 0; left:0; background-color:#c6c6c6"
                class="flex p-1 w-full items-center">
                    <a class="lg:w-2/5" href="{{ url('/projects') }}">
                        <img src="/images/logo.svg">
                    </a>
                    @auth()
                    <div class="lg:w-3/5" class="justify-start">
                        <a class="lg:px-4 px-1 hover:no-underline hover:text-grey-darkest text-grey-lightest lg:font-extrabold" href="/projects">ANNOUNCEMENTS</a>
                        <a class="lg:px-4 px-1 hover:no-underline hover:text-grey-darkest text-grey-lightest lg:font-extrabold" href="/calendar">CALENDAR</a>
                        <a class="lg:px-4 px-1 hover:no-underline hover:text-grey-darkest text-grey-lightest lg:font-extrabold" href="/archive">ARCHIVE</a>
                        @can('delete-project')
                            <a class="lg:px-4 px-1 hover:no-underline hover:text-grey-darkest text-grey-lightest lg:font-extrabold" href="/users">USERS</a>
                        @endcan
                    </div>
                    @endauth 
                </div>
            </template>
        </visible>  
    </main>
 
@endsection