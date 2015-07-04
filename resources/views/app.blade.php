<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Tetsche">
        <meta name="keywords" lang="de" content="Tetsche, stern, Kalauerkönig, Tetsche-Seite, Kalau{{ isset($keywords) ? ', ' . $keywords : '' }}">
        @if (isset($description))
            <meta name="description" lang="de" content="{{ $description }}">
        @endif
        <title>{{ isset($title) ? $title . ' | ': '' }}Tetsche</title>
        <link rel="shortcut icon" href="{{ asset('images/website/favicon.ico') }}">
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
            @include('partials.info')
            @yield('content')
        </div>

        <script src="{{ asset(elixir('js/all.js')) }}"></script>
        @include('additional_javascript')
    </body>
</html>
