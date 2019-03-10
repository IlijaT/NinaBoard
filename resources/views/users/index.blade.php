@extends('layouts.app')
@section('content')
    {{-- <header  class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-lg text-grey text-sm font-normal">
                <a href="/users" 
                class="text-lg text-grey text-sm font-normal"
                style="text-decoration: none;"
                >
                All Users
                </a>
            </p>
            
            <add-new-user></add-new-user>
        </div>
    </header> --}}

    <header class="flex justify-between items-end w-full mt-2 mb-4">

        <div>
            <a href="/users"
            class=" hover:no-underline"
            >
            <span class="text-normal text-grey font-bold hover:text-blue">All users</span>
            </a>
        </div>
            
        <add-new-user></add-new-user>
        
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