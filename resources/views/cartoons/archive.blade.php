@extends('layouts.app')

@section('content')
    <h1>Archiv</h1>

    <div class="container-fluid">
        @foreach (array_chunk($dates->all(), 4) as $row)
            <div class="row">
                @foreach ($row as $date)
                    <div class="col-xs-6 col-md-3">
                        <a class="thumbnail" href="{!! action([App\Http\Controllers\CartoonsController::class, 'show'], ['date' => $date->publish_on]) !!}">
                            <img class="center-block img-responsive" src="{!! asset($date->cartoon->thumbnailPath()) !!}" {!! $date->cartoon->thumbnailSizeAndDescription() !!} />
                        </a>
                        <p class="text-center">
                            {!! Carbon\Carbon::parse($date->publish_on)->locale('de')->isoFormat('Do MMMM YYYY') !!}
                        </p>
                    </div>
                @endforeach
            </div>
        @endforeach
        {!! str_replace('/?', '?', $dates->render()) !!}
    </div>
@stop
