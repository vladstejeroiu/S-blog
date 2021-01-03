<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SooperBlog') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container-fluid">
                <!-- Links to landing page -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'SooperBlog') }}
                </a>
                <!-- Navigation hamburger icon -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Nav links -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-lg-0 ml-auto">
                        <!-- If user is a guest/not logged in -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link {{ Request::path() === 'posts' ? 'active' : '' }}" href="{{ route('posts.index') }}">Recent Posts</a>
                        </li>

                        <!-- Authentication links -->
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link {{ Request::path() === 'login' ? 'active' : '' }}" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link {{ Request::path() === 'register' ? 'active' : '' }}" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif

                        <!-- If user is logged in (not a guest) -->
                        @else
                        <li class="nav-item">
                            <span class="nav-link text-success">Hey, {{ Auth::user()->name }}!</span>
                        </li>

                        <!-- Link to home -->
                        <li class="nav-item">
                            <a class="nav-link {{ Request::path() === 'home' ? 'active' : '' }}" href="{{ url('/home') }}">
                                Home
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::path() === 'posts' ? 'active' : '' }}" href="{{ route('posts.index') }}">Recent Posts</a>
                        </li>

                        <!-- Logout link -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </li>
                        <!-- Form uses csrf tag to prevent CSRF attacks -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main page content is contained here -->
        <main class="py-4 container">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="text-center py-4 border-top">
            {{ config('app.name', 'SooperBlog') }} 2021 &copy; | All rights reserved
        </footer>
    </div>
</body>

</html>