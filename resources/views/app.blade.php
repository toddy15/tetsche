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
        <link rel="shortcut icon" href="{{ asset('theme/images/favicon.ico') }}">
        <link rel="icon" sizes="192x192" href="{{ asset('theme/images/puempel-192x192.png') }}">
        @foreach ([180, 152, 144, 120, 114, 76, 72, 60, 57] as $res)
            <link rel="apple-touch-icon" sizes="{{ $res }}x{{ $res }}" href="{{ asset('theme/images/puempel-' . $res . 'x' . $res . '.png') }}">
        @endforeach
        <link href="{{ asset(elixir('theme/css/all.css')) }}" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="{{ asset(elixir('theme/js/ie8.js')) }}"></script>
        <![endif]-->
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

        <script src="{{ asset(elixir('theme/js/all.js')) }}"></script>
        @include('additional_javascript')
    </body>
</html>
