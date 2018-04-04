@extends('app')

@section('content')
<h1 style="color:#fdb3b4;">{{ $pagetitle or $title }}</h1>
<h3 style="color:#fdb3b4;">Angaben gemäß § 5 TMG</h3>
<p>
    Tetsche<br />
    c/o stern<br />
    Baumwall 11<br />
    20459 Hamburg
</p>
<h3 style="color:#fdb3b4;">Kontakt</h3>
<p>
    E-Mail: <a style="color:#ff0" href="mailto:tetsche@tetsche.de">tetsche@tetsche.de</a><br />
    Telefon: <a style="color:#ff0" href="tel:+49-40-3703-0">+49 40 3703-0</a>
</p>
<h3 style="color:#fdb3b4;">Verantwortlich für den Inhalt nach § 55 Abs. 2 RStV</h3>
<p>
    Tetsche<br />
    c/o stern<br />
    Baumwall 11<br />
    20459 Hamburg<br />
</p>
<h3 style="color:#fdb3b4;">Widerspruch Werbe-Mails</h3>
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
