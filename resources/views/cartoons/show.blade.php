@extends('layouts.app')

@section('content')
    <h1>{{ $pagetitle ?? $title }}</h1>

    <img class="d-block mx-auto img-fluid"
         src="{{ asset($cartoon->imagePath()) }}" {!! $cartoon->imageSizeAndDescription() !!} />
    @if ($cartoon->rebus)
        <div class="card text-dark bg-info">
            <div class="card-body">
                <p class="card-text text-center">Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.</p>
                <p class="text-center">
                    Auflösung nächste Woche im
                    <a href="{!! route('archiv.index') !!}">Archiv</a>.
                </p>
            </div>
        </div>
    @endif
@stop
