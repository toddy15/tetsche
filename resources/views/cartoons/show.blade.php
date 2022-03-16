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
                        <button id="solution-button" class="btn btn-primary text-center" onclick="showSolution()">
                            Lösung anzeigen
                        </button>
                        <p id="solution" class="text-center d-none mt-4">{{ $cartoon->rebus }}</p>
                        <script>
                            function showSolution() {
                                var solution = document.getElementById("solution");
                                solution.classList.toggle("d-none");
                                var button = document.getElementById("solution-button");
                                if (button.innerText === "Lösung anzeigen") {
                                    button.innerText = "Lösung verstecken";
                                } else {
                                    button.innerText = "Lösung anzeigen";
                                }
                            }
                        </script>
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
