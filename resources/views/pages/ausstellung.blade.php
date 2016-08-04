@extends('app')

@section('content')
    <h1>Ausstellung in der Fabrik der Künste</h1>
    <img class="center-block img-responsive" src="{{ asset('images/ausstellung.jpg') }}" alt="Ausstellung" title="Ausstellung" width="618" height="853" />
    <p>
        Ausstellung: 6.&nbsp;September bis 2.&nbsp;Oktober<br />
        Vernissage am 6.&nbsp;September um 19&nbsp;Uhr<br />
        Laudatio: Wigald Boning<br />
        Die Künstler sind anwesend
    </p>
    <p>
        Finissage: 2.&nbsp;Oktober um 17&nbsp;Uhr<br />
        Mit einem Werkstattgespräch der Künstler
    </p>
    <p>
        Eintritt: 5&nbsp;€, Kinder und Jugendliche haben freien Entritt<br />
        Öffnungszeiten: Di. bis Fr. von 15 bis 19&nbsp;Uhr, Sa. bis So. von 12 bis 18&nbsp;Uhr
    </p>
    <address>
        <strong>FABRIK DER KÜNSTE</strong><br />
        Kreuzbrook 12<br />
        20537 Hamburg<br />
        Tel.: <a href="tel:+49-40-86685717">+49 40 86685717</a><br />
        <a href="http://www.fabrikderkuenste.de/">www.fabrikderkuenste.de</a>
    </address>
@stop
