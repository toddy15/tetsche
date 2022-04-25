@extends('layouts.app')

@section('content')
    <h1>{{ $pagetitle ?? $title }}</h1>
    <h2>Angaben gemäß § 5 TMG</h2>
    <p>
        Tetsche<br />
        c/o stern<br />
        Baumwall 11<br />
        20459 Hamburg
    </p>
    <h2>Kontakt</h2>
    <p>
        E-Mail: <a href="mailto:tetsche@tetsche.de">tetsche@tetsche.de</a><br />
        Telefon: <a href="tel:+49-40-3703-0">+49 40 3703-0</a>
    </p>
    <h2>Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV</h2>
    <p>
        Tetsche<br />
        c/o stern<br />
        Baumwall 11<br />
        20459 Hamburg<br />
    </p>
    <h2>Widerspruch Werbe-Mails</h2>
    <p>
        Der Nutzung von im Rahmen der Impressumspflicht
        veröffentlichten Kontaktdaten zur Übersendung von
        nicht ausdrücklich angeforderter Werbung und
        Informationsmaterialien wird hiermit widersprochen.
        Die Betreiber der Seiten behalten sich ausdrücklich
        rechtliche Schritte im Falle der unverlangten Zusendung
        von Werbeinformationen, etwa durch Spam-E-Mails, vor.
    </p>
@stop
