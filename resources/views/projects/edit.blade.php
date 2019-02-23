@extends('layouts.app')
@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
        <h1 class="text-2xl font-normal mb-10 text-center">
            Edit This Project
        </h1>

        <form action="{{ $project->path() }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="field mb-6">
                <label class="label text-sm mb-2 block" for="title">Title</label>

                <div class="control">
                    <input
                        type="text"
                        class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                        name="title"
                       
                        value="{{ $project->title }}"
                    >
               
                    @if ($errors->has('title'))
                    <span 
                        style="width: 100%; margin-top: .25rem; font-size: 80%; color: #e3342f;"
                        role="alert"
                    ><strong>{{ $errors->first('title') }}</strong>
                    </span>   
                    
                    @endif
                </div>
            </div>

            <div class="field mb-6">
                <label class="label text-sm mb-2 block" for="description">Description</label>

                <div class="control">
                    <textarea
                        name="description"
                        rows="10"
                        class="textarea bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                        placeholder="Project description here..."
                        >{{ $project->description }}</textarea>
                   
                    @if ($errors->has('description'))
                    <span 
                        style="width: 100%; margin-top: .25rem; font-size: 80%; color: #e3342f;"
                        role="alert"
                    ><strong>{{ $errors->first('description') }}</strong>
                    </span>   
                    
                    @endif
                </div>
            </div>

            <div class="flex">
                <div class="ml-auto control">
                    <a 
                    style="text-decoration: none" 
                    class="mr-2 no-underline text-blue text-lg hover:text-blue-darkest rounded-lg py-2 px-3 border border-black"
                    href="{{ $project->path() }}">Cancel</a>
                    <button class="text-lg button text-white is-link hover:bg-blue-dark">Update</button>
                </div>
            </div>
        </form>
    </div>

       
 
@endsection 
 