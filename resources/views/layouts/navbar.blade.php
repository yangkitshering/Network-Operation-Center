<!doctype html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Soelra Package System') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <section class="ftco-section">
        <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
            <div class="container">
                <a class="navbar-brand" href="/">Soelra Package<span>System</span></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                    aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-bars"></span> Menu
                </button>
                <div class="collapse navbar-collapse" id="ftco-nav">
                    <ul class="navbar-nav m-auto">
                        <!-- <li class="nav-item active"><a href="#" class="nav-link">Home</a></li> -->
                        {{-- <li class="nav-item"><a href="{{ route('talktime') }}" class="nav-link">Talk-Time</a></li>
                        <li class="nav-item"><a href="{{ route('data') }}" class="nav-link">Data</a></li>
                        <li class="nav-item"><a href="{{ route('history') }}" class="nav-link">Recharge History</a></li>
                        <li class="nav-item"><a href="{{ route('profile') }}" class="nav-link">Profile</a></li>--}}
                        <li class="nav-item"><a href="{{ route('logout') }}" 
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit()"
                                class="nav-link">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- END nav -->
    </section>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>

    <!-- Content Section -->
    <div class="py-5">
        @yield('content')
    </div>

    <!-- JavaScripts -->
    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('js/popper.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/main.js') }}"></script> --}}

</body>

</html>