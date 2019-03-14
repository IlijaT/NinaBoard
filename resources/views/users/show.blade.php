@extends('layouts.app')
@section('content')

    <header class="flex justify-between items-end w-full mt-2 mb-4">
        <div>
            @can('delete-project')
            <a href="/users"
            class=" hover:no-underline"
            >
            <span class="text-normal text-grey font-bold hover:text-blue">All users /</span>
            </a>
            @endcan
            <span class="text-normal text-grey font-normal ">{{ $user->name }}</span>
        </div>
        <edit-user :user="{{ $user }}"></edit-user>
    </header>


    {{-- user profile card --}}
    <div class="flex bg-white rounded-lg shadow-md h-64 w-full">
        {{-- left side blue--}}
        <avatar-form :user="{{ $user }}"></avatar-form>
        {{-- right white side--}}
        <div class="flex flex-col ml-4 w-full">
            {{-- achievements icons --}}
            <div class="flex m-2 flex-wrap justify-center">
                <div class="rounded-full h-8 w-8 bg-grey-lighter m-2">
                    1
                </div>
                <div class="rounded-full h-8 w-8 bg-grey-lighter m-2">
                    2
                </div>
                <div class="rounded-full h-8 w-8 bg-grey-lighter m-2">
                    3
                </div>
                <div class="rounded-full h-8 w-8 bg-grey-lighter m-2">
                    4
                </div>
                <div class="rounded-full h-8 w-8 bg-grey-lighter m-2">
                    5
                </div>
            </div>

            {{-- user profile details --}}
            <div class="mb-auto">
                <h1 class="text-black text-2xl font-bold">{{$user->name}}</h1>
                <h2 class="text-grey text-xl font-normal">Email: {{$user->email}}</h2>
                <h2 class="text-grey text-xl font-normal">Role: {{$user->hasRole('manager') ? 'Manager' : 'Operator'}}</h2>
            </div>

            {{-- footer with achievements --}}
            <div class="flex justify-center m-2">
                <h2 class="text-grey text-sm font-normal m-2">Completed tasks: 55</h2>
                <h2 class="text-grey text-sm font-normal m-2">Created assignements: 555</h2>
            </div>
        </div>
    </div>

    
    <user-stats :user="{{$user}}"></user-stats>

@endsection