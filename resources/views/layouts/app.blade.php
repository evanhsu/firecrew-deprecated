<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    @yield('stylesheets')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    @section('scripts-preload')

    @show
</head>
<body>
    <div id="app">
        @include('menubar')

        @if (Session::has('alert'))
            <div class="alert alert-{{ isset(Session::get('alert')['type']) ? Session::get('alert')['type'] : 'info' }}" role="alert">
                {{ Session::get('alert')['message'] }}
            </div>
        @endif

        @yield('content')
    </div>

    @section('scripts-postload')
    <!-- Scripts -->
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    @show

</body>
</html>
