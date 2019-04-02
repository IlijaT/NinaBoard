<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}: @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('images/favicon2.ico') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{-- Trix text editor - wysiwyg --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.0/trix.css">
</head>
<body class="bg-grey-light font-sans h-screen">
    
    <div id="app" class="h-full">
        @include('layouts.navbar')

        <main class="container py-2">
            @yield('content')
        </main>

        <flash-component message='{{ session('flash.message') }}' color='{{ session('flash.color') }}
        ' class="z-50"></flash-component>
    </div>
    
    <footer class="mt-auto p-4">
        <div class="text-grey text-xs text-center">
            &copy; BirdBoard {{ \Carbon\Carbon::now()->year }}. All rights reserved. Yes, all of them. Developed by Ilija
        </div>
    </footer>

</body>
</html>
