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
    <title>{{ isset($title) ? $title . ' | ': '' }}Tetsche</title>

    <link rel="canonical" href="{!! urldecode(Request::url()) !!}"/>
    <link rel="shortcut icon" href="{{ asset('theme/images/favicon.ico') }}">
    <link rel="icon" sizes="192x192" href="{{ asset('theme/images/puempel-192x192.png') }}">
    @foreach ([180, 152, 144, 120, 114, 76, 72, 60, 57] as $res)
        <link rel="apple-touch-icon" sizes="{{ $res }}x{{ $res }}"
              href="{{ asset('theme/images/puempel-' . $res . 'x' . $res . '.png') }}">
    @endforeach

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @include('partials.nav')

        <div class="container-xl">
            @include('partials.errors')
            @include('partials.info')

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </div>

    @include('additional_javascript')
    <!-- Matomo -->
    <script type="text/javascript">
        var _paq = window._paq = window._paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function () {
            var u = "https://www.tetsche.de/matomo/";
            _paq.push(['setTrackerUrl', u + 'matomo.php']);
            _paq.push(['setSiteId', '1']);
            var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
            g.type = 'text/javascript';
            g.async = true;
            g.src = u + 'matomo.js';
            s.parentNode.insertBefore(g, s);
        })();
    </script>
    <noscript>
        <img referrerpolicy="no-referrer-when-downgrade"
             src="https://www.tetsche.de/matomo/matomo.php?idsite=1&amp;rec=1" style="border:0" alt=""/>
    </noscript>
    <!-- End Matomo Code -->
</body>
</html>