<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #fa6666;">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">Home</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item {{ Request::is('tetsche') ? 'active' : ''}}">
                    <a class="nav-link {{ Request::is('tetsche') ? 'active' : '' }}" {!! Request::is('tetsche') ? 'aria-current="page"' : '' !!} href="{{ url('tetsche') }}">Tetsche</a>
                </li>
                <li class="nav-item {{ Request::is('cartoon') ? 'active' : ''}}">
                    <a class="nav-link {{ Request::is('cartoon') ? 'active' : '' }}" {!! Request::is('cartoon') ? 'aria-current="page"' : '' !!} href="{{ url('cartoon') }}">Cartoon</a>
                </li>
                <li class="nav-item {{ Request::is('archiv') ? 'active' : ''}}">
                    <a class="nav-link {{ Request::is('archiv') ? 'active' : '' }}" {!! Request::is('archiv') ? 'aria-current="page"' : '' !!} href="{{ url('archiv') }}">Archiv</a>
                </li>
                <li class="nav-item {{ Request::is('bücher') ? 'active' : ''}}">
                    <a class="nav-link {{ Request::is('bücher') ? 'active' : '' }}" {!! Request::is('bücher') ? 'aria-current="page"' : '' !!} href="{{ url('bücher') }}">Bücher</a>
                </li>
                <li class="nav-item {{ Request::is('gästebuch') ? 'active' : ''}}">
                    <a class="nav-link {{ Request::is('gästebuch') ? 'active' : '' }}" {!! Request::is('gästebuch') ? 'aria-current="page"' : '' !!} href="{{ url('gästebuch') }}">Gästebuch</a>
                </li>
                <li class="nav-item {{ Request::is('impressum') ? 'active' : ''}}">
                    <a class="nav-link {{ Request::is('impressum') ? 'active' : '' }}" {!! Request::is('impressum') ? 'aria-current="page"' : '' !!} href="{{ url('impressum') }}">Impressum</a>
                </li>
                <li class="nav-item {{ Request::is('datenschutzerklärung') ? 'active' : ''}}">
                    <a class="nav-link {{ Request::is('datenschutzerklärung') ? 'active' : '' }}" {!! Request::is('datenschutzerklärung') ? 'aria-current="page"' : '' !!} href="{{ url('datenschutzerklärung') }}">Datenschutzerklärung</a>
                </li>

                @unless (Auth::guest())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ action([App\Http\Controllers\SpamController::class, 'index']) }}">Administration
                                    des Gästebuchs</a></li>
                        <li><a class="dropdown-item" href="{{ action([App\Http\Controllers\CartoonsController::class, 'index']) }}">Administration
                                    der Cartoons</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ url('/logout') }}">Abmelden</a></li>
                    </ul>
                </li>
                @endunless
            </ul>
        </div>
    </div>
</nav>
