@extends('layouts.app')
@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
        <h1 class="text-2xl font-normal mb-10 text-center">
            Create an Announcement
        </h1>

        <form action="/projects" method="POST">
            @csrf
            
            <div class="field mb-6">
                <label class="label text-sm mb-2 block" for="title">Title</label>

                <div class="control">
                    <input
                        type="text"
                        class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                        name="title"
                        placeholder="Project title here..."
                        required
                        >
                </div>
                @if ($errors->has('title'))
                    <span 
                        style="width: 100%; margin-top: .25rem; font-size: 80%; color: #e3342f;"
                        role="alert"
                    ><strong>{{ $errors->first('title') }}</strong>
                @endif
            </div>

            <div class="field mb-6">
                <label class="label text-sm mb-2 block" for="description">Description</label>

                <div class="control">
                        <textarea
                            name="description"
                            rows="10"
                            class="textarea bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                            placeholder="Project description here..."
                            required></textarea>
                </div>
            </div>

            <div class="flex">
                <div class="ml-auto control">
                    <a style="text-decoration: none" class="mr-2 no-underline text-blue text-lg hover:text-blue-darkest rounded-lg py-2 px-3 border border-black" href="/projects">Cancel</a>
                    <button class="text-lg button text-white is-link hover:bg-blue-dark">Create</button>
                </div>
            </div>
        </form>
    </div>

       
 
@endsection 
 