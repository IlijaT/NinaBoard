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
                    <tasks-component :projecttasks="{{ $project->tasks }}"></tasks-component>
        
                </div>

                <div>
                    <h2 class="text-sm text-grey font-normal my-3">General Notes</h2>
                    
                    <!-- General notes -->
                    <general-notes :project="{{ $project }}"></general-notes>

                </div>
                

            </div>
        
            {{-- rigt side of left side --}}
            <project-card 
                :project="{{ $project }}"
                :logged="{{ auth()->user()->with('roles')->find(auth()->id()) }}">
            </project-card>

        </div>

    </div>

    {{-- rigt side - project activity feed --}}
    <div class="lg:w-1/4">

        <latest-project-updates 
            :activities="{{ $project->activities()->with(['subject', 'user'])->get() }}">
        </latest-project-updates>

    </div>


</div>
@endsection 