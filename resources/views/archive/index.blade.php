@extends('layouts.app')

@section('content')
    <h1>Archiv</h1>

    @foreach (array_chunk($dates->all(), 4) as $row)
        <div class="row">
            @foreach ($row as $date)
                <div class="col-12 col-sm-6 col-lg-3 text-center mb-4">
                    <a href="{!! route('archiv.show', $date->publish_on) !!}">
                        <img class="img-thumbnail img-fluid mb-2" src="{!! asset($date->cartoon->thumbnailPath()) !!}" {!! $date->cartoon->thumbnailSizeAndDescription() !!} />
                    </a>
                    <p class="text-center">
                        {!! Carbon\Carbon::parse($date->publish_on)->locale('de')->isoFormat('Do MMMM YYYY') !!}
                    </p>
                </div>
            @endforeach
        </div>
    @endforeach

    <div class="d-flex justify-content-center">
        {{ $dates->links() }}
    </div>
@stop
