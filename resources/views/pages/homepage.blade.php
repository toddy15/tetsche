@extends('layouts.app')

@section('content')
    <h1 class="display-1 mb-5">Tetsche-Website</h1>

    {{-- <div class="text-center">
        <img class="img-fluid" src="{{ asset('images/hund-grinsend.jpg') }}" alt="Grinsender Hund" width="552"
             height="361"/>
    </div> --}}
    <p class="lead text-center">
        Saukomische Tetsche-Ausstellung im
        <a href="http://www.sommerpalais-greiz.de/ausstellung/tetsche-saukomisch">Sommerpalais Greiz</a><br>
        11. Juni 22&nbsp;–&nbsp;31. Oktober 22
    </p>
    <div class="text-center">
        <a href="http://www.sommerpalais-greiz.de/ausstellung/tetsche-saukomisch">
            <img class="img-fluid" src="{{ asset('images/greiz.webp') }}" width="961" height="1062"
                alt="Poster für Tetsche-Ausstellung im Sommerpalais Greiz" />
        </a>
    </div>
@stop
