@extends('layouts.app')
@section('content')
    <header  class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <h2 class="text-grey text-sm font-normal">All Users</h2>
            <a class="text-lg button text-white is-link hover:bg-blue-dark" style="text-decoration: none;" href="/users/create">New User</a>
        </div>
    </header>

    <main>
        <div class="lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
            @forelse($users as $user)
                <div class="list-group">
                    <a href="/users/{{$user->id}}" class="list-group-item list-group-item-action">{{ $user->name}}</a>
                </div>
            @empty
                <div>No Users Yet</div>
            @endforelse
        </div>
    </main>
 
@endsection