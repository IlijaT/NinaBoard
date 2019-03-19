@extends('layouts.app')
@section('content')

    <header class="flex justify-between items-end w-full mt-2 mb-4">

        <div>
            <a href="/users"
            class=" hover:no-underline"
            >
            <span class="hover:no-underline hover:text-blue text-sm text-grey-dark font-normal">All users</span>
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