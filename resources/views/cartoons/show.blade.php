@extends('layouts.app')

@section('content')
    <h1>{{ $pagetitle ?? $title }}</h1>

    <img class="d-block mx-auto img-fluid"
         src="{{ asset($cartoon->imagePath()) }}" {!! $cartoon->imageSizeAndDescription() !!} />
    @if ($cartoon->rebus)
        <div class="card text-dark bg-info">
            <div class="card-body">
                <p class="card-text text-center">Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.</p>
                @if ($cartoon->showRebusSolution)
                    <div class="text-center">
                        {{-- @TODO: Make button work again --}}
                        <button id="btn-solution" type="button" class="btn btn-primary text-center">Lösung anzeigen
                        </button>
                        <p id="solution" class="text-center d-none">{{ $cartoon->rebus }}</p>
                    </div>
                @else
                    <p class="text-center">
                        Auflösung nächste Woche im
                        <a href="{!! action([App\Http\Controllers\CartoonsController::class, 'showArchive']) !!}">Archiv</a>.
                    </p>
                @endif
            </div>
        </div>
    @endif
@stop
