<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('backend/main.css') }}" rel="stylesheet">
    @stack('css')
</head>
<body>
    <div id="app">
        <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
            @include('layouts.backend.partials.header')

            <div class="app-main">
                @include('layouts.backend.partials.sidebar')
                <div class="app-main__outer">
                    <div class="app-main__inner">
                        @yield('content')
                    </div>
                @include('layouts.backend.partials.footer')
                </div>
                <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('scripts/resources/js/frontend.js') }}"></script>
    <script src="{{ asset('frontend/js/app.js') }}"></script>
    <script type="text/javascript" src="{{asset('backend/assets/scripts/main.js')}}"></script>
    <script src="{{asset('backend/assets/scripts/sweetalert2.js')}}"></script>
    @stack('js')
</body>
</html>
