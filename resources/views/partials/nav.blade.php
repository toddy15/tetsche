        <nav class="navbar navbar-expand-md navbar-light bg-danger shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Home
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item {{ Request::is('tetsche') ? 'active' : ''}}">
                            <a class="nav-link {{ Request::is('tetsche') ? 'active' : '' }}"
                               {!! Request::is('tetsche') ? 'aria-current="page"' : '' !!} href="{{ url('tetsche') }}">Tetsche</a>
                        </li>
                        <li class="nav-item {{ Request::is('cartoon') ? 'active' : ''}}">
                            <a class="nav-link {{ Request::is('cartoon') ? 'active' : '' }}"
                               {!! Request::is('cartoon') ? 'aria-current="page"' : '' !!} href="{{ url('cartoon') }}">Cartoon</a>
                        </li>
                        <li class="nav-item {{ Request::is('archiv') ? 'active' : ''}}">
                            <a class="nav-link {{ Request::is('archiv') ? 'active' : '' }}"
                               {!! Request::is('archiv') ? 'aria-current="page"' : '' !!} href="{{ url('archiv') }}">Archiv</a>
                        </li>
                        <li class="nav-item {{ Request::is('bücher') ? 'active' : ''}}">
                            <a class="nav-link {{ Request::is('bücher') ? 'active' : '' }}"
                               {!! Request::is('bücher') ? 'aria-current="page"' : '' !!} href="{{ url('bücher') }}">Bücher</a>
                        </li>
                        <li class="nav-item {{ Request::is('gästebuch') ? 'active' : ''}}">
                            <a class="nav-link {{ Request::is('gästebuch') ? 'active' : '' }}"
                               {!! Request::is('gästebuch') ? 'aria-current="page"' : '' !!} href="{{ url('gästebuch') }}">Gästebuch</a>
                        </li>
                        <li class="nav-item {{ Request::is('impressum') ? 'active' : ''}}">
                            <a class="nav-link {{ Request::is('impressum') ? 'active' : '' }}"
                               {!! Request::is('impressum') ? 'aria-current="page"' : '' !!} href="{{ url('impressum') }}">Impressum</a>
                        </li>
                        <li class="nav-item {{ Request::is('datenschutzerklärung') ? 'active' : ''}}">
                            <a class="nav-link {{ Request::is('datenschutzerklärung') ? 'active' : '' }}"
                               {!! Request::is('datenschutzerklärung') ? 'aria-current="page"' : '' !!} href="{{ url('datenschutzerklärung') }}">Datenschutzerklärung</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        {{--
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        --}}
                        @unless(Auth::guest())
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endunless
                    </ul>
                </div>
            </div>
        </nav>

        {{--
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
        --}}
