@extends('layouts.app')

@section('content')
    <h1>Das neue Tetsche-Buch ist da!</h1>
    <p>
        Anlässlich der Finissage der
        <a href="https://burg-zu-hagen.de/event/ausstellung-tetsche-saukomisch/">Ausstellung »Tetsche – saukomisch!«</a>
        in der Burg zu Hagen im Bremischen
        findet am Sonntag, 7. April ab 15 Uhr eine
        Buchpräsentation mit Signierstunde statt.
    </p>
    <div class="text-center">
        <x-image :src="$vorne" :width="1000" :height="1000" class="img-fluid"
            alt="Tetsche – Prallvoll (Vorderseite)" />
    </div>
    <div class="text-center">
        <x-image :src="$hinten" :width="1000" :height="1000" class="img-fluid"
            alt="Tetsche – Prallvoll (Rückseite)" />
    </div>
@stop
