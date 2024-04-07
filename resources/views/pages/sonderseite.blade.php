@extends('layouts.app')

@section('content')
    <h1>Das neue Tetsche-Buch ist da!</h1>
    <h2>Tetsche – Prallvoll!</h2>
    <p>
        Jahrzehntelang hatte Tetsche eine eigene Seite im Magazin stern.
        Mit seinen unverwechselbaren Cartoons und Rebussen und seiner
        unbändigen Freude an Wortspielen und Kalauern wurde er zu einem
        der bekanntesten deutschen Cartoonisten. Inzwischen arbeitet er
        an Cartoons, Grafiken und Skulpturen, die in vielen Ausstellungen
        deutschlandweit zu sehen sind. In diesem Buch ist das Neueste
        und Beste aus den letzten Jahren versammelt.
    </p>
    <p>
        Mit Texten über Tetsche und sein Werk von Piet Klocke,
        Til Mette und Hasnain Kazim.
    </p>
    <div class="text-center">
        <p>
            <a href="https://www.carlsen.de/hardcover/tetsche-prallvoll/978-3-8303-3691-4" class="btn btn-danger">Carlsen
                Buchverlag</a>
        </p>
        <p>
            <a href="https://www.hugendubel.de/de/buch_gebunden/tetsche-tetsche_prallvoll-47047812-produkt-details.html"
                class="btn btn-danger">Bei Hugendubel ansehen</a>
        </p>
        <p>
            <a href="https://www.thalia.de/shop/home/artikeldetails/A1069847139" class="btn btn-danger">Bei Thalia
                ansehen</a>
        </p>
        <p>
            <a href="https://www.amazon.de/Tetsche-Prallvoll-Cartoons-Rebusse-Installationen/dp/3830336918"
                class="btn btn-danger">Bei
                Amazon ansehen</a>
        </p>
    </div>
    <div class="text-center">
        <x-image :src="$vorne" :width="1000" :height="1000" class="img-fluid"
            alt="Tetsche – Prallvoll! (Vorderseite)" />
    </div>
    <div class="text-center">
        <x-image :src="$hinten" :width="1000" :height="1000" class="img-fluid"
            alt="Tetsche – Prallvoll! (Rückseite)" />
    </div>
@stop
