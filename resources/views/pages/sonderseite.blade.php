@extends('app')

@section('content')
    <h1 style="color:#fdb3b4;font-size:81px;margin-bottom:80px;">Tetsche-Website</h1>

    <div class="row">
        <div class="col-md-6" style="margin-bottom: 30px; text-align: center;">
            <a href="https://www.amazon.de/Platsch-Fridos-Sprung-ins-Abenteuer/dp/3830312849/">
            <img style="margin-bottom:40px" class="center-block img-responsive" src="{{ asset('images/platsch-cover.jpg') }}"
                 alt="Platsch! Fridos Sprung ins Abenteuer" title="Platsch! Fridos Sprung ins Abenteuer" width="660" height="807" />
            </a>
            <h2 style="color:#fdb3b4">NEU!</h2>
            <p>
                Tetsches allererstes Kinderbuch ist da!<br/>
                Mit gereimten Versen von Hannes Lukas!
            </p>
            <p>
                Voll mit wunderbar farbigen doppelseitigen Illustrationen
                zu der abenteuerlichen Geschichte von Frosch Frido und seinen Freunden
                Günni Gras und Willem Busch.<br/>
                Mit vielen lustigen Details zum Suchen und Entdecken.<br/>
                Für Kinder von 3 &ndash; 8 Jahren
            </p>
            <p>
                ISBN 978-3-8303-1284-0<br/>
                Lappan / Carlsen Verlag<br/>
                € 12,99
            </p>
            <p>
                Ab sofort in jeder Buchhandlung erhältlich.
            </p>
            <p>
                <a href="https://www.amazon.de/Platsch-Fridos-Sprung-ins-Abenteuer/dp/3830312849/" class="btn btn-danger">Bei Amazon ansehen</a>
            </p>
        </div>
        <div class="col-md-6" style="margin-bottom: 30px; text-align: center;">
            <a href="https://www.amazon.de/Cartoons-andere-Kostbarkeiten-Tetsche/dp/3830335164/">
            <img class="center-block img-responsive" src="{{ asset('images/gesundheit.jpg') }}"
                 alt="Tetsche &ndash; Cartoons und andere Kostbarkeiten" title="Tetsche &ndash; Cartoons und andere Kostbarkeiten" width="596" height="842" />
            </a>
            <h2 style="color:#fdb3b4">Endlich!</h2>
            <h2 style="color:#fdb3b4">Cartoons &amp; andere Kostbarkeiten</h2>
            <p>
                Das neue, große dicke Tetsche-Buch ist da!<br />
                Live und in Farbe, 208&nbsp;fette Seiten
            </p>
            <p>
                Lappan Verlag<br />
                ISBN 978-3-8303-3516-0
            </p>
            <p>
                <a href="https://www.amazon.de/Cartoons-andere-Kostbarkeiten-Tetsche/dp/3830335164/" class="btn btn-danger">Bei Amazon ansehen</a>
            </p>
            <p>
                <a href="https://www.carlsen.de/hardcover/cartoons-und-andere-kostbarkeiten/96575" class="btn btn-danger">Lappan-Verlag</a>
            </p>
        </div>
    </div>

@stop
