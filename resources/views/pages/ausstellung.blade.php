@extends('app')

@section('content')
    <h1 style="color:#fdb3b4;font-size:81px;margin-bottom:80px;">Tetsche-Website</h1>
    <img class="center-block img-responsive" src="{{ asset('images/hund-grinsend.jpg') }}" alt="Hund" title="Hund" width="729" height="1204" />
    <h2 class="text-center" style="color:#fdb3b4">Ausstellung im Caricatura Museum Frankfurt</h2>
    <div class="container" style="margin-bottom:20px;">
        <div class="row">
            <div class="col-md-6">
                <img class="center-block img-responsive" src="{{ asset('images/stern-bilder.jpg') }}" alt="Ausstellung" title="Ausstellung" width="500" height="690" />
            </div>
            <div class="col-md-6">
                <p>
                    Die Ausstellung zeigt neben den Klassikern vor allem
                    die aktuell im stern vertretenen Zeichner und Humoristen.
                    Im Mittelpunkt werden die drei großen Komischen Künstler
                    Gerhard Haderer, Til Mette und Tetsche stehen.
                </p>
                <address>
                    <strong>Caricatura Museum Frankfurt</strong><br />
                    Museum für Komische Kunst<br />
                    Weckmarkt 17<br />
                    60311 Frankfurt am Main<br />
                    Tel.: <a style="color:#ff0" href="tel:+49-69-21230161">+49 69 212 301 61</a><br />
                    <a style="color:#ff0" href="http://caricatura-museum.de/">www.caricatura-museum.de</a>
                </address>
            </div>
        </div>
    </div>
@stop
