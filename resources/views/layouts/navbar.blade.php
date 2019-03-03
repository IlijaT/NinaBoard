<nav class="navbar navbar-expand-md navbar-light navbar-laravel bg-white flex flex-column">
  <div class="container">
      <h1>
          <a class="navbar-brand" href="{{ url('/projects') }}">
              <img src="/images/logo.svg">
          </a>
      </h1>
     
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">
              <!-- Authentication Links -->
              @guest
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </li>
              @else
                  <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img class="rounded-full h-12 w-12 flex items-center justify-center" 
                            src="{{ Auth::user()->avatar_path }}" 
                            >
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                
                            <a class="dropdown-item" href="/projects">Announcements</a>
                            <a class="dropdown-item" href="/calendar">Calendar</a>
                            @can('delete-project')
                                <a class="dropdown-item" href="/users">Users</a>
                            @endcan
                            <a class="dropdown-item" href="/users/{{auth()->id()}}">Profile</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </div>
                  </li>
              @endguest
          </ul>
      </div>
  </div>

    <div class="flex justify-center pb-1">
        @auth()
        <a class="px-4 hover:no-underline hover:text-blue text-grey font-extrabold" href="/projects">ANNOUNCEMENTS</a>
        <a class="px-4 hover:no-underline hover:text-blue text-grey font-extrabold" href="/calendar">CALENDAR</a>
        @can('delete-project')
            <a class="px-4 hover:no-underline hover:text-blue text-grey font-extrabold" href="/users">USERS</a>
        @endcan
        @endauth 
    </div>

</nav>

