<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tetsche</title>
        <link href="{{ asset(elixir('css/all.css')) }}" rel="stylesheet">
    </head>
    <body>
        @include('partials.nav')

        <div class="container">
            <!--[if lt IE 9]>
            <p>
                Sie verwenden einen veralteten Browser.
                <a href="http://browsehappy.com/">Aktualisieren Sie Ihren Browser noch heute</a>,
                um diese Website fehlerlos ansehen zu können.
            </p>
            <![endif]-->
            @include('errors.list')
            @yield('content')
        </div>

        <script src="{{ asset(elixir('js/all.js')) }}"></script>
        @include('additional_javascript')
    </body>
</html>
