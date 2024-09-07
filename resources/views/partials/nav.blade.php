<nav class="navbar navbar-expand-md navbar-dark shadow-sm navbar-custom-background">
    <div class="container">
        <a class="navbar-brand" href="{{ route('homepage') }}">
            Home
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item {{ Route::is('tetsche') ? 'active' : '' }}">
                    <a class="nav-link {{ Route::is('tetsche') ? 'active' : '' }}" {!! Route::is('tetsche') ? 'aria-current="page"' : '' !!}
                        href="{{ route('tetsche') }}">Tetsche</a>
                </li>
                <li class="nav-item {{ Request::is('cartoon') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('cartoon') ? 'active' : '' }}" {!! Request::is('cartoon') ? 'aria-current="page"' : '' !!}
                        href="{{ url('cartoon') }}">Cartoon</a>
                </li>
                <li class="nav-item {{ Request::is('archiv') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('archiv') ? 'active' : '' }}" {!! Request::is('archiv') ? 'aria-current="page"' : '' !!}
                        href="{{ url('archiv') }}">Archiv</a>
                </li>
                <li class="nav-item {{ Route::is('buecher') ? 'active' : '' }}">
                    <a class="nav-link {{ Route::is('buecher') ? 'active' : '' }}" {!! Route::is('buecher') ? 'aria-current="page"' : '' !!}
                        href="{{ route('buecher') }}">Bücher</a>
                </li>
                <li class="nav-item {{ Request::is('gaestebuch') ? 'active' : '' }}">
                    <a class="nav-link {{ Request::is('gaestebuch') ? 'active' : '' }}" {!! Request::is('gaestebuch') ? 'aria-current="page"' : '' !!}
                        href="{{ route('gaestebuch.index') }}">Gästebuch</a>
                </li>
                <li class="nav-item {{ Route::is('impressum') ? 'active' : '' }}">
                    <a class="nav-link {{ Route::is('impressum') ? 'active' : '' }}" {!! Route::is('impressum') ? 'aria-current="page"' : '' !!}
                        href="{{ route('impressum') }}">Impressum</a>
                </li>
                <li class="nav-item {{ Route::is('datenschutz') ? 'active' : '' }}">
                    <a class="nav-link {{ Route::is('datenschutz') ? 'active' : '' }}" {!! Route::is('datenschutz') ? 'aria-current="page"' : '' !!}
                        href="{{ route('datenschutz') }}">Datenschutz</a>
                </li>
            </ul>

            @unless (Auth::guest())
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item"
                                    href="{{ action([App\Http\Controllers\SpamController::class, 'index']) }}">
                                    Administration des Gästebuchs
                                </a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('publication_dates.index') }}">Administration
                                    der Cartoons</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                    Abmelden
                                </a>
                            </li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            @endunless
        </div>
    </div>
</nav>
