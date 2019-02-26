@extends('layouts.app')
@section('content')
    <header  class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-lg text-grey text-sm font-normal">
                <a href="/users" 
                class="text-lg text-grey text-sm font-normal"
                style="text-decoration: none;"
                >
                All Users
                </a>
            </p>
            <a class="py-1 px-4 text-lg button rounded-full text-white is-link hover:bg-blue-dark border-2 border-blue" style="text-decoration: none;" href="/users/create">New User</a>
        </div>
    </header>

    <main>
        <div class="lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
            @forelse($users as $user)
                <div class="list-group">
                    <a href="/users/{{$user->id}}" class="text-normal list-group-item list-group-item-action">
                        {{ $user->name}} - <span class="text-xs">  {{$user->hasRole('manager') ? 'manager' : 'operator'}} </span>
                    </a>
                </div>
            @empty
                <div>No Users Yet</div>
            @endforelse
        </div>
    </main>
 
@endsection