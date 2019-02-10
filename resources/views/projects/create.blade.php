@extends('layouts.app')
@section('content')

    <form action="/projects" method="POST">
        @csrf
        <h1 class="heading is-1">Create a Project</h1>
        
        <div class="field">
            <label class="label">Title</label>
            <div class="control">
                <input name="title" class="input" type="text" placeholder="Text input">
            </div>
        </div>

        <div class="field">
        <label class="label">Descriptoin</label>
        <div class="control">
            <textarea name="description" class="textarea" placeholder="Textarea"></textarea>
        </div>
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-link">Create Project</button>
                <a href="/projects">Cancel</a>
            </div>
        </div>
    </form>
@endsection 
 