@extends('layouts.app')
@section('title', 'User profile | '.$user->name )
@section('content')

    <header class="flex justify-between items-end w-full mt-2 mb-4">
        <div>
            @can('delete-project')
            <a href="/users"
            class=" hover:no-underline"
            >
            <span class="hover:no-underline hover:text-blue text-sm text-grey-dark font-normal">All users /</span>
            </a>
            @endcan
            <span class="text-normal text-grey font-normal ">{{ $user->name }}</span>
        </div>
    <edit-user :user=" {{ $user }} " :logged=" {{ auth()->user() }} "></edit-user>
    </header>


    {{-- user profile card --}}
    <div class="flex h-64 bg-white rounded-lg shadow-md w-full">
        {{-- left side blue--}}
        <avatar-form :user="{{ $user }}"></avatar-form>
        {{-- right white side--}}
        <div class="flex flex-col ml-4 w-full">
            {{-- achievements icons --}}
            <div class="flex m-2 flex-wrap justify-center">
              
                <div 
                    class="tooltips {{ $user->activity()->where('description','completed_task')->count() > 1 ? 'bg-blue-dark' : 'bg-grey-lighter' }} 
                     flex items-center justify-center rounded-full h-8 w-8 m-2 shadow-md">
                     <span class="text-xs">1 completed task</span>
                    <i class="text-white fas fa-rocket text-lg "></i>
                </div>
                <div 
                    class="tooltips {{ $user->activity()->where('description','completed_task')->count() > 10 ? 'bg-green' : 'bg-grey-lighter' }} 
                     flex items-center justify-center rounded-full h-8 w-8 m-2 shadow-md">
                     <span class="text-xs">10 completed tasks</span>
                    <i class="fas fa-star text-lg text-white"></i>
                </div>
                <div class="tooltips {{ $user->activity()->where('description','completed_task')->count() > 100 ? 'bg-yellow-dark' : 'bg-grey-lighter' }} flex items-center justify-center rounded-full h-8 w-8 m-2 shadow-md">
                        <span class="text-xs">100 completed tasks</span>
                    <i class="fas fa-award text-lg text-white"></i>
                </div>
                <div class="tooltips {{ $user->activity()->where('description','completed_task')->count() > 500 ? 'bg-orange' : 'bg-grey-lighter' }} flex items-center justify-center rounded-full h-8 w-8 m-2 shadow-md">
                    <span class="text-xs">500 completed tasks</span>
                    <i class="fas fa-medal text-lg text-white"></i>
                </div>
                <div class="tooltips {{ $user->activity()->where('description','completed_task')->count() > 1000 ? 'bg-red' : 'bg-grey-lighter' }} flex items-center justify-center rounded-full h-8 w-8 m-2 shadow-md">
                    <span class="text-xs">1000 completed tasks</span>
                    <i class="fas fa-trophy text-lg text-white"></i>
                </div>
            </div>

            {{-- user profile details --}}
            <div class="mb-auto">
                <h1 class="text-black text-2xl font-bold">{{$user->name}}</h1>
                <h2 class="text-grey text-xl font-normal">Email: {{$user->email}}</h2>
                <h2 class="text-grey text-xl font-normal">Role: {{$user->hasRole('manager') ? 'Manager' : 'Operator'}}</h2>
            </div>

            {{-- footer with achievements --}}
            <div class="flex justify-center m-2 p-1">
                <h2 class="text-grey text-xs font-normal mr-3">
                    <i class="fas fa-bullhorn text-xs text-grey"></i>
                    {{ $user->activity()->where('description','created_task')->count() }}
                </h2>
                <h2 class="text-grey text-xs font-normal">
                    <i class="fas fa-feather-alt text-xs text-grey"></i>
                    {{ $user->activity()->where('description','completed_task')->count() }} 
                </h2>
            </div>
        </div>
    </div>

    
    <user-stats :user="{{$user}}"></user-stats>

@endsection