@extends('app')

@section('content')
    <h1 style="color:#fdb3b4;font-size:81px;margin-bottom:80px;">Tetsche-Website</h1>
    <img class="center-block img-responsive" src="{{ asset('images/hund-grinsend.jpg') }}" alt="Hund" title="Hund" width="552" height="361" />
    <h2 class="text-center" style="color:#fdb3b4">Ausstellung in Hamburg, Fabrik der Künste</h2>
    <div class="container" style="margin-bottom:20px;">
        <div class="row">
            <div class="col-md-6">
                <img class="center-block img-responsive" src="{{ asset('images/ausstellung.jpg') }}" alt="Ausstellung" title="Ausstellung" width="500" height="690" />
            </div>
            <div class="col-md-6">
                <p>
                    Ausstellung: 6.&nbsp;September bis 2.&nbsp;Oktober
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
                    Tel.: <a style="color:#ff0" href="tel:+49-40-86685717">+49 40 86685717</a><br />
                    <a style="color:#ff0" href="http://www.fabrikderkuenste.de/">www.fabrikderkuenste.de</a>
                </address>
            </div>
        </div>
    </div>
@stop
