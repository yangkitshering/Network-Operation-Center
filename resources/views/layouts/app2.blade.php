<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RUB Digital Certificates') }}</title>

    <link rel="icon" href="{{ asset('images/rub.png') }}" type="image/gif" sizes="16x16">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slider.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hover-min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.0/css/ionicons.min.css">
</head>

<body>
    <section class="top-bar animated-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="navbar-brand" href="/">
                            <img src="../images/logo.png" alt="logo" width="70">
                            <span class="pl-3 cd-headline">Network Operation Center</span>
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        {{-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto">
                                @guest
                                @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                @endif

                                @else
                                <li class="nav-item ml-2 mr-2 mt-1">
                                    <a class="nav-link" href="{{ route('register-certificate') }}">{{ __('Register
                                        Certificate')
                                        }}</a>
                                </li>

                                <li class="nav-item ml-2 mr-2 mt-1">
                                    <a class="nav-link" href="{{ route('verify') }}">{{ __('View Certificate') }}</a>
                                </li>

                                @if (Auth::user()->hasRole('admin'))
                                <li class="nav-item ml-2 mr-2 mt-1">
                                    <a class="nav-link" href="{{ route('manage-user') }}">{{ __('Manage User') }}</a>
                                </li>
                                @endif

                                <li class="nav-item ml-2 mr-2 mt-1">
                                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                                @endguest
                            </ul>
                        </div> --}}
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <main>
        @yield('content')
    </main>

</body>

<!-- Footer -->
<footer id="footer">
    <div class="container">
        <div class="row content-justify-between">
            <div class="col-md-8 col-12 text-center text-lg-left text-md-left">
                <p class="copyright">Copyright © Bhutan Telecom Limited
                    <?php echo date("Y"); ?>.<br>
                </p>
            </div>

        </div>
    </div>
</footer>
<!-- /#footer -->

<!-- Javascript Files -->
<script src="{{ asset('js/app.js') }}"></script>
{{-- <script src="{{ asset('js/sweetalert2.js') }}" defer></script> --}}
<script src="{{ asset('js/slider.js') }}"></script>

</body>

</html>