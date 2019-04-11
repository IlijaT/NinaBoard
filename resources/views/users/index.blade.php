@extends('layouts.app')
@section('title', 'Users')
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
        <div class="table-responsive ">
            <table class="table lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
                    <thead class="bg-grey-light text-black">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td class="flex items-end">
                                    <img class="mr-2 rounded-full h-6 w-6 justify-center" 
                                        src="{{ $user->avatar_path }}" 
                                    >
                                    {{ $user->name }}
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{$user->roles[0]->name }}</td>
                                <td>
                                    <a href="/users/{{$user->id}}">
                                        <i class="fas fa-eye text-lg text-grey-dark"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>    
        
           
    </main>
 
@endsection