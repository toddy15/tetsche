@extends('layouts.app')

@section('content')
    <h1>{{ $pagetitle ?? $title }}</h1>
    <h2>Datenschutz</h2>
    <p>
        Wir nehmen den Schutz Ihrer persönlichen Daten sehr ernst.
        Wir behandeln Ihre personenbezogenen Daten vertraulich und
        entsprechend der gesetzlichen Datenschutzvorschriften sowie
        dieser Datenschutzerklärung.
    </p>
    <p>
        Die Nutzung unserer Website ist ohne Angabe personenbezogener
        Daten möglich. Soweit auf unseren Seiten personenbezogene Daten
        (beispielsweise ein Name im Gästebuch)
        erhoben werden, erfolgt dies stets auf freiwilliger Basis.
        Diese Daten werden nicht an Dritte weitergegeben.
    </p>
    <p>
        Wir weisen darauf hin, dass die Datenübertragung im Internet
        (beispielsweise bei der Kommunikation per E-Mail)
        Sicherheitslücken aufweisen kann. Ein lückenloser Schutz der
        Daten vor dem Zugriff durch Dritte ist nicht möglich.
    </p>
    <h2>Cookies</h2>
    <p>
        Die Internetseiten verwenden Cookies.
        Cookies richten auf Ihrem Rechner keinen Schaden an und
        enthalten keine Viren. Cookies dienen dazu, unser Angebot
        nutzerfreundlicher, effektiver und sicherer zu machen.
        Cookies sind kleine Textdateien, die auf Ihrem Rechner
        abgelegt werden und die Ihr Browser speichert.
    </p>
    <p>
        Alle von uns verwendeten Cookies sind technisch notwendige
        »Session-Cookies«. Sie werden nach Ende Ihres Besuchs automatisch
        gelöscht.
    </p>
    <h2>Server-Log-Files</h2>
    <p>
        Informationen, die Ihr Browser automatisch an uns übermittelt
        (beispielsweise Browsertyp und -version, verwendetes
        Betriebssystem etc.), speichern wir nicht.
    </p>
    <h2>Kommentarfunktion auf dieser Website</h2>
    <p>
        Für die Kommentarfunktion auf dieser Seite werden neben
        Ihrem Kommentar auch Angaben zum Zeitpunkt der Erstellung
        des Kommentars und, wenn Sie nicht anonym posten, der
        von Ihnen gewählte Nutzername gespeichert.
    </p>
    <h3>Speicherung der IP-Adresse</h3>
    <p>
        Unsere Kommentarfunktion speichert die IP-Adressen der
        Nutzer, die Kommentare verfassen. Da wir Kommentare auf
        unserer Seite nicht vor der Freischaltung prüfen,
        benötigen wir diese Daten, um im Falle von Rechtsverletzungen
        wie Beleidigungen oder Propaganda gegen den Verfasser
        vorgehen zu können.
        IP-Adressen speichern wir über einen Zeitraum von maximal
        sieben Tagen.
    </p>
    <h2>SSL-Verschlüsselung</h2>
    <p>
        Diese Seite nutzt aus Gründen der Sicherheit und zum
        Schutz der Übertragung aller Inhalte eine
        SSL-Verschlüsselung. Eine verschlüsselte Verbindung
        erkennen Sie daran, dass die Adresszeile des Browsers
        von »http://« auf »https://« wechselt und an dem
        Schloss-Symbol in Ihrer Browserzeile.
    </p>
    <p>
        Wenn die SSL-Verschlüsselung aktiviert ist, können die
        Daten, die Sie an uns übermitteln, nicht von
        Dritten mitgelesen werden.
    </p>
    <h2>Recht auf Auskunft, Berichtigung, Sperrung, Löschung</h2>
    <p>
        Sie haben jederzeit das Recht auf unentgeltliche Auskunft
        über Ihre gespeicherten personenbezogenen Daten, deren
        Herkunft und Empfänger und den Zweck der Datenverarbeitung
        sowie ein Recht auf Berichtigung, Sperrung oder Löschung
        dieser Daten. Hierzu sowie zu weiteren Fragen zum Thema
        personenbezogene Daten können Sie sich jederzeit unter
        der im <a href="{{ route('impressum') }}">Impressum</a> angegebenen
        Adresse an uns wenden.
    </p>
    <div class="card text-dark bg-info">
        <div class="card-header">
            <h2>Widerspruchsrecht</h2>
        </div>
        <div class="card-body">
            <p class="card-text">
                Sie haben jederzeit das Recht, gegen die Verarbeitung
                Ihrer personenbezogenen Daten Widerspruch einzulegen.
            </p>
        </div>
    </div>
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
