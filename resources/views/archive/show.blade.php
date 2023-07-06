@extends('layouts.app')

@section('content')
    <h1>{{ $pagetitle }}</h1>

    <img class="d-block mx-auto img-fluid" src="{{ asset($date->cartoon->imagePath()) }}" {!! $date->cartoon->imageSizeAndDescription() !!} />
    @if ($date->cartoon->rebus)
        <div class="card text-dark bg-info">
            <div class="card-body">
                <p class="card-text text-center">Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.</p>
                <div class="text-center">
                    <button id="solution-button" class="btn btn-primary text-center">
                        Lösung anzeigen
                    </button>
                    <p id="solution" class="text-center d-none mt-4">{{ $date->cartoon->rebus }}</p>
                </div>
            </div>
        </div>
    @endif
@stop
