@extends('layouts.app')
@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
        <h1 class="text-2xl font-normal mb-10 text-center">
            Edit User
        </h1>

        <form action="/users/{{ $user->id }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="field mb-6">
                <label class="label text-sm mb-2 block" for="title">Name</label>

                <div class="control">
                    <input
                        type="text"
                        class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                        name="name"
                       
                        value="{{ $user->name }}"
                    >
               
                    @if ($errors->has('name'))
                    <span 
                        style="width: 100%; margin-top: .25rem; font-size: 80%; color: #e3342f;"
                        role="alert"
                    ><strong>{{ $errors->first('name') }}</strong>
                    </span>   
                    
                    @endif
                </div>
            </div>

            <div class="field mb-6">
                <label class="label text-sm mb-2 block" for="title">Password</label>

                <div class="control">
                    <input
                        type="password"
                        class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                        name="password"
                       
                        value="{{ $user->password }}"
                    >
               
                    @if ($errors->has('password'))
                    <span 
                        style="width: 100%; margin-top: .25rem; font-size: 80%; color: #e3342f;"
                        role="alert"
                    ><strong>{{ $errors->first('password') }}</strong>
                    </span>   
                    
                    @endif
                </div>
            </div>

            <div class="field mb-6">
                <label class="label text-sm mb-2 block" for="title">Password</label>

                <div class="control">
                    <input
                        type="password"
                        class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                        name="password_confirmation"
                        
                        value="{{ $user->password }}"
                    >
                
                    @if ($errors->has('password'))
                    <span 
                        style="width: 100%; margin-top: .25rem; font-size: 80%; color: #e3342f;"
                        role="alert"
                    ><strong>{{ $errors->first('password') }}</strong>
                    </span>   
                    
                    @endif
                </div>
            </div>

            <div class="flex">
                <div class="ml-auto flex">
                    <a 
                    style="text-decoration: none" 
                    class="mr-2 no-underline text-grey-darker text-lg hover:border-blue hover:text-blue rounded-full py-1 px-4 border-2 border-grey"
                    href="/users/{{ $user->id }}">Cancel</a>
                    <button class="py-1 px-4 text-lg button rounded-full text-white is-link hover:bg-blue-dark border-2 border-blue">Update</button>
                </div>
            </div>
        </form>
    </div>

       
 
@endsection 
 