@extends('layouts.app')
@section('content')
    <header class="flex items-center mb-3 py-4">
        <h1>{{$user->name}}</h1>
        <a 
        style="text-decoration: none" 
        class="ml-auto no-underline text-blue text-lg hover:text-blue-darkest rounded-lg py-2 px-3 border border-black"
        href="/users/{{ $user->id }}/edit">Edit Details</a>
    </header>
    <hr>
    <main>
        <div>
            
            <img class="rounded-full" 
                src="{{ asset('/storage/'.$user->avatar()) }}" 
                height="80" width="80">
            
            <form action="/users/{{ $user->id }}/avatar" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="avatar">
                <button class="btn btn-primary" type="submit">Submit</button>
            </form>
            
            <h2 class="text-grey text-xl font-normal">Email: {{$user->email}}</h2>

        </div>
        <div>
    </main>
 
@endsection