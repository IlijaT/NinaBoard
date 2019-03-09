@extends('layouts.app')
@section('content')

    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-lg text-grey text-sm font-normal">
                @can('delete-project')
                <a href="/users" 
                class="text-lg text-grey text-sm font-normal hover:text-blue hover:no-underline"
                >
                All users
                </a> 
                @endcan
               / {{ $user->name }}
            </p>
            {{-- <a 
            style="text-decoration: none" 
            class="ml-auto py-1 px-4 text-lg button rounded-full text-white hover:bg-blue-dark"
            href="/users/{{ $user->id }}/edit">Edit</a> --}}
            <edit-user :user="{{ $user }}"></edit-user>
        </div>
    </header>

    <div class="flex bg-white rounded-lg shadow-md h-64 w-full">
         
            {{-- left --}}
                 
            <avatar-form :user="{{ $user }}"></avatar-form>
               

            {{-- right --}}
            <div class="flex flex-col ml-4 w-full">
                <div class="flex mt-1">
                    <div class="rounded-full h-10 w-10 bg-grey-lighter m-2">

                    </div>
                    <div class="rounded-full h-10 w-10 bg-grey-lighter m-2">

                    </div>
                    <div class="rounded-full h-10 w-10 bg-grey-lighter m-2">

                    </div>
                    <div class="rounded-full h-10 w-10 bg-grey-lighter m-2">

                    </div>
                    <div class="rounded-full h-10 w-10 bg-grey-lighter m-2">

                    </div>

                </div>
                <div class="mb-auto">
                    <h1>{{$user->name}}</h1>
                    <hr>
                    <h2 class="text-grey text-xl font-normal">Email: {{$user->email}}</h2>
                    <h2 class="text-grey text-xl font-normal">Role: {{$user->hasRole('manager') ? 'Manager' : 'Operator'}}</h2>
                    

                </div>
                <div class="flex justify-center m-2">
                    <h2 class="text-grey text-sm font-normal m-2">Completed tasks: 55</h2>
                    <h2 class="text-grey text-sm font-normal m-2">Created assignements: 555</h2>
                </div>
            </div>
    </div>
    
@endsection