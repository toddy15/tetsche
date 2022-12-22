<!doctype html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="author" content="Tetsche">
    @if (isset($description))
        <meta name="description" lang="de" content="{{ $description }}">
    @endif
    <title>{{ isset($title) ? $title . ' | ' : '' }}Tetsche</title>

    <link rel="canonical" href="{!! urldecode(Request::url()) !!}" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset(mix('apple-touch-icon.png')) }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset(mix('favicon-32x32.png')) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(mix('favicon-16x16.png')) }}">
    <link rel="manifest" href="{{ asset(mix('site.webmanifest')) }}">
    <link rel="mask-icon" href="{{ asset(mix('safari-pinned-tab.svg')) }}" color="#5bbad5">
    <link rel="shortcut icon" href="{{ asset(mix('favicon.ico')) }}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-white">
    @include('partials.nav')

    <div class="container mt-4">
        @include('partials.errors')
        @include('partials.info')

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Matomo -->
    <script>
        var _paq = window._paq = window._paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u = "https://matomo.tetsche.de/";
            _paq.push(['setTrackerUrl', u + 'matomo.php']);
            _paq.push(['setSiteId', '1']);
            var d = document,
                g = d.createElement('script'),
                s = d.getElementsByTagName('script')[0];
            g.async = true;
            g.src = u + 'matomo.js';
            s.parentNode.insertBefore(g, s);
        })();
    </script>
    <noscript>
        <img referrerpolicy="no-referrer-when-downgrade" src="https://matomo.tetsche.de/matomo.php?idsite=1&amp;rec=1"
            style="border:0" alt="" />
    </noscript>
    <!-- End Matomo Code -->
</body>

</html>
