@extends('layouts.app')

@section('content')
    <h1>{{ $pagetitle ?? $title }}</h1>

    <div>
        <img class="center-block img-responsive" src="{{ $cartoon->imagePath() }}" {!! $cartoon->imageSizeAndDescription() !!} />
    </div>
    @if ($cartoon->rebus)
        <div class="panel panel-default">
            <div class="panel-body bg-info">
                <p class="text-center">Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.</p>
                @if ($cartoon->showRebusSolution)
                    <div class="text-center">
                        <button id="btn-solution" type="button" class="btn btn-primary text-center">Lösung anzeigen</button>
                        <p id="solution" class="text-center hidden">{{ $cartoon->rebus }}</p>
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
