<html>
    <head>
        <title>@yield('title')</title>
        <link href="css/app.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>