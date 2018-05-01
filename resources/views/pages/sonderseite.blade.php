@extends('app')

@section('content')
    <h1 style="color:#fdb3b4;font-size:81px;margin-bottom:80px;">Tetsche-Website</h1>

    <div class="row">
        <div class="col-sm-6">
            <img style="margin-bottom:40px" class="center-block img-responsive" src="{{ asset('images/platsch-cover.jpg') }}"
                 alt="Platsch! Fridos Sprung ins Abenteuer" title="Platsch! Fridos Sprung ins Abenteuer" width="660" height="807" />
        </div>
        <div class="col-sm-6">
            <h2 style="color:#fdb3b4">Ausstellung</h2>
            <p>
                Ausstellung bei den Vegesacker Kindertagen<br />
                Samstag, 5. Mai 2018, mit Lesungen von 11&ndash;15 Uhr<br />
                Es gibt Live-Musik und Popcorn<br />
                In der havengalerie<br />
                Bremen-Vegesack, Alte Hafenstr. 27
            </p>
            <p>
                Tetsche und Hannes Lukas sind anwesend!
            </p>
            <p>
                <a href="https://www.havengalerie.de/" class="btn btn-danger">Website der havengalerie</a>
            </p>
        </div>
    </div>

@stop
