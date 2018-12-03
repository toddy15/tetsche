<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">Home</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li {!! Request::is('tetsche') ? 'class="active"' : '' !!}><a href="{{ url('tetsche') }}">Tetsche</a></li>
                @if (date("Y-m-d H:i") >= "2018-12-12 18:00")
                <li {!! Request::is('cartoon') ? 'class="active"' : '' !!}><a href="{{ url('cartoon') }}">Cartoon</a></li>
                @else
                <li {!! Request::is('stern') ? 'class="active"' : '' !!}><a href="{{ url('stern') }}">Stern</a></li>
                @endif
                <li {!! Request::is('archiv') ? 'class="active"' : '' !!}><a href="{{ url('archiv') }}">Archiv</a></li>
                <li {!! Request::is('bücher') ? 'class="active"' : '' !!}><a href="{{ url('bücher') }}">Bücher</a></li>
                <li {!! Request::is('gästebuch') ? 'class="active"' : '' !!}><a href="{{ url('gästebuch') }}">Gästebuch</a></li>
                <li {!! Request::is('impressum') ? 'class="active"' : '' !!}><a href="{{ url('impressum') }}">Impressum</a></li>
                <li {!! Request::is('datenschutzerklärung') ? 'class="active"' : '' !!}><a href="{{ url('datenschutzerklärung') }}">Datenschutzerklärung</a></li>
            </ul>

            @unless (Auth::guest())
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ action('SpamController@index') }}">Administration des Gästebuchs</a></li>
                            <li><a href="{{ action('CartoonsController@index') }}">Administration der Cartoons</a></li>
                            <li><a href="{{ url('/auth/logout') }}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            @endunless
        </div>
    </div>
</nav>
