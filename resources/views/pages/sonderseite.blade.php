@extends('app')

@section('content')
    <h1 style="color:#fdb3b4;font-size:81px;margin-bottom:80px;">Tetsche-Website</h1>

    <div class="row">
        <div class="col-sm-6">
            <img style="margin-bottom:40px" class="center-block img-responsive" src="{{ asset('images/platsch-cover.jpg') }}"
                 alt="Platsch! Fridos Sprung ins Abenteuer" title="Platsch! Fridos Sprung ins Abenteuer" width="660" height="807" />
            <img style="margin-bottom:40px" class="center-block img-responsive" src="{{ asset('images/platsch-innen.jpg') }}"
                 alt="Platsch! Innenseite" title="Platsch! Innenseite" width="600" height="587" />
        </div>
        <div class="col-sm-6">
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
                Für Kinder von 3 - 8 Jahren
            </p>
            <p>
                ISBN 978<span>-3</span>-8303-<span>1284<span>-0<br/>
                Lappan / Carlsen Verlag<br/>
                € 12,99
            </p>
            <p>
                Ab sofort in jeder Buchhandlung erhältlich.
            </p>
            <p>
                <a href="https://www.hannes-lukas.de/" class="btn btn-danger">Website von Hannes Lukas</a>
                <a href="https://www.carlsen.de/hardcover/platsch/93241" class="btn btn-danger">Bei Carlsen ansehen</a>
            </p>
        </div>
    </div>

@stop
