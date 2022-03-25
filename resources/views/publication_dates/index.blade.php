@extends('layouts.app')

@section('content')
    <h1>Übersicht aller Cartoons</h1>
    <p>
        <a href="{!! action([App\Http\Controllers\CartoonsController::class, 'forceNewCartoon']) !!}"
           class="btn btn-primary">Zufällig neuer nächster Cartoon</a>
    </p>

    @foreach (array_chunk($dates->all(), 4) as $row)
        <div class="row">
            @foreach ($row as $date)
                <div class="col-12 col-sm-6 col-lg-3 text-center mb-4">
                    <a href="{{ route('publication_dates.edit', $date) }}">
                        <img class="img-thumbnail img-fluid mb-2"
                             src="{{ asset($date->cartoon->thumbnailPath()) }}" {!! $date->cartoon->thumbnailSizeAndDescription() !!} />
                    </a>
                    <p class="text-center">
                        {{ Carbon\Carbon::parse($date->publish_on)->locale('de')->isoFormat('Do MMMM YYYY') }}
                    </p>
                </div>
            @endforeach
        </div>
    @endforeach

    {{-- @TODO: Center pagination --}}
    {{ $dates->links() }}
@stop
