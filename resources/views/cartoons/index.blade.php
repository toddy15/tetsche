@extends('layouts.app')

@section('content')
    <h1>Übersicht aller Cartoons</h1>
    <p>
        <a href="{!! action([App\Http\Controllers\CartoonsController::class, 'create']) !!}" class="btn btn-primary">Neuer Cartoon</a>
        <a href="{!! action([App\Http\Controllers\CartoonsController::class, 'forceNewCartoon']) !!}" class="btn btn-default">Zufällig neuer nächster Cartoon</a>
    </p>

    <div class="container-fluid">
        @foreach (array_chunk($publication_dates->all(), 4) as $row)
            <div class="row">
                @foreach ($row as $publication_date)
                    <div class="col-xs-6 col-md-3">
                        <a class="thumbnail" href="{!! action([App\Http\Controllers\CartoonsController::class, 'edit'], ['id' => $publication_date->cartoon_id]) !!}">
                            <img class="center-block img-responsive" src="{!! asset($publication_date->cartoon->thumbnailPath()) !!}" {!! $publication_date->cartoon->thumbnailSizeAndDescription() !!} />
                        </a>
                        <p class="text-center">
                            {!! Carbon\Carbon::parse($publication_date->publish_on)->formatLocalized('%e. %B %Y') !!}
                        </p>
                    </div>
                @endforeach
            </div>
        @endforeach
        {!! str_replace('/?', '?', $publication_dates->render()) !!}
    </div>
@stop
