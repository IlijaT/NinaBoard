@extends('layouts.app')
@section('content')

    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-lg text-grey text-sm font-normal">
               <a href="/users" 
                class="text-lg text-grey text-sm font-normal"
                style="text-decoration: none;"
                >
                All Users
                </a>  / {{ $user->name }}
            </p>
            <a 
            style="text-decoration: none" 
            class="ml-auto no-underline text-xl button text-white is-link hover:bg-blue-dark"
            href="/users/{{ $user->id }}/edit">Edit Details</a>
        </div>
    </header>

    <div class="flex mb-3 py-4 bg-white p-3 mb-3 rounded-lg shadow-md  w-full">
            <avatar-form :user="{{ $user }}" class="m-5"></avatar-form>
            <div class="flex flex-col ml-4 content-between">
                <div class="my-auto">
                    <h1>{{$user->name}}</h1>
                    <hr>
                    <h2 class="text-grey text-xl font-normal">Email: {{$user->email}}</h2>
                    <h2 class="text-grey text-xl font-normal">Role: {{$user->hasRole('manager') ? 'Manager' : 'Operator'}}</h2>
                </div>
            </div>
    </div>
    
 
@endsection