<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  </head>
</head>
<body>
    @include('sweet::alert')
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @auth
                    <a class="navbar-brand" href="{{ url('home') }}">
                        {{ config('app.name', 'Daigakusei') }}
                    </a>
                @endauth
                @guest
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                @endguest
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @hasrole('super-admin')
                            @if (Auth::user()->unreadNotifications()->count() > 0)
                                <a href="{{ route('home') }}">
                                    <span class="badge badge-pill badge-success">
                                        New Registration Request
                                        <span class="badge badge-light">
                                            {{ Auth::user()->unreadNotifications()->count() }}
                                        </span>
                                    </span>
                                </a>
                            @else
                                <span></span>
                            @endif
                        @endhasrole
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('home.profile') }}">
                                        Profile
                                    </a>

                                    {{-- super admin menu --}}
                                    @hasrole('super-admin')
                                        <a href="{{ route('super-admin.users') }}" class="dropdown-item">
                                            Users List
                                        </a>
                                        <a href="{{ route('super-admin.show-criteria') }}" class="dropdown-item">
                                            Criteria List
                                        </a>
                                        <hr>
                                    @endhasrole
                                    
                                    {{-- admin university menu --}}
                                    @hasrole('university-admin')
                                        <a class="dropdown-item" href="{{ route('university.university-profile') }}">
                                            University and Majors List
                                        </a>
                                        <hr>
                                    @endhasrole
                                    
                                    {{-- Student menu --}}
                                    @hasrole('user-student')
                                            <a class="dropdown-item" href="{{ route('student.show-universities') }}">
                                                University List
                                            </a>
                                        <hr>
                                    @endhasrole

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
