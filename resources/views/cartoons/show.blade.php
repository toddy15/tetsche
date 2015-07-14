@extends('app')

@section('content')
    <h1>Tetsche im »stern« vom {{ Carbon\Carbon::parse($cartoon->publish_on)->formatLocalized('%e. %B %Y') }}</h1>

    <div>
        <img class="center-block img-responsive" src="{!! asset($cartoon->imagePath()) !!}" {!! $cartoon->imageSizeAndDescription() !!} />
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
                    <p class="text-center">Auflösung nächste Woche an dieser Stelle.</p>
                @endif
            </div>
        </div>
    @endif
@stop