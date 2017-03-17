@extends('app')

@section('content')
    <h1 style="color:#fdb3b4;font-size:81px;margin-bottom:80px;">Tetsche-Website</h1>
    <img class="center-block img-responsive" src="{{ asset('images/hund-grinsend.jpg') }}" alt="Hund" title="Hund" width="729" height="1204" />
    <h2 class="text-center" style="color:#fdb3b4">Ausstellung in der havengalerie Bremen</h2>
    <div class="container" style="margin-bottom:20px;">
        <div class="row">
            <div class="col-md-6">
                <img class="center-block img-responsive" src="{{ asset('images/havengalerie.jpg') }}" alt="Ausstellung" title="Ausstellung" width="538" height="1182" />
            </div>
            <div class="col-md-6">
                <p>
                    25. März bis 27. Mai<br />
                    Vernissage am 24. März um 18:00 Uhr
                </p>
                <p>
                    Öffnungszeiten:<br />
                    Dienstag &ndash; Freitag von 10:00 &ndash; 12:30 Uhr und 15:00 &ndash; 18:00 Uhr<br />
                    Samstag von 10:00 &ndash; 14:00 Uhr<br />
                    Eintritt frei
                </p>
                <address>
                    <strong>havengalerie</strong><br />
                    Alte Hafenstraße 27<br />
                    28757 Bremen<br />
                    Tel.: <a style="color:#ff0" href="tel:+49-421-69200896">+49 421 69200896</a><br />
                    <a style="color:#ff0" href="https://www.havengalerie.de/">www.havengalerie.de</a>
                </address>
            </div>
        </div>
    </div>
@stop
