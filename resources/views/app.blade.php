<!DOCTYPE html>
<html lang="de">
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
        <meta name="MSSmartTagsPreventParsing" content="TRUE">
    </head>
    {{-- Hack to display the blue pages --}}
    @if (Request::is('/') or Request::is('impressum'))
        <body style="background:#437cff;color:#fff;">
    @else
        <body>
    @endif
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
        <!-- Piwik -->
        <script type="text/javascript">
            var _paq = _paq || [];
            _paq.push(['trackPageView']);
            _paq.push(['enableLinkTracking']);
            (function() {
                var u="//www.tetsche.de/piwik/";
                _paq.push(['setTrackerUrl', u+'piwik.php']);
                _paq.push(['setSiteId', 1]);
                var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
            })();
        </script>
        <noscript><p><img src="//www.tetsche.de/piwik/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
        <!-- End Piwik Code -->
    </body>
</html>
