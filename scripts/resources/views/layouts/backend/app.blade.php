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
    <style type="text/css">
        .notifyjs-corner{
            z-index: 10000 !important;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        @if(session()->has('success'))
                        <script type="text/javascript">
                            $(function(){
                                $.notify("{{session()->get('success')}}",{globalPosition:'top right',className:'success'});
                            });
                        </script>
                        @endif
                        @if(session()->has('error'))
                        <script type="text/javascript">
                        $(function(){
                            $.notify("{{session()->get('error')}}",{globalPosition:'top right',className:'error'});
                        });
                        </script>
                        @endif
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
    <!-- Izitoast -->
    @stack('js')
</body>
</html>
