@extends('app')

@section('content')
    <h1>Archiv</h1>

    <div class="container-fluid">
        @foreach (array_chunk($cartoons->all(), 4) as $row)
            <div class="row">
                @foreach ($row as $cartoon)
                    <div class="col-xs-6 col-md-3">
                        <a class="thumbnail" href="{!! action('CartoonsController@show', ['date' => $cartoon->publish_on]) !!}">
                            <img class="center-block img-responsive" src="{!! asset($cartoon->thumbnailPath()) !!}" {!! $cartoon->thumbnailSizeAndDescription() !!} />
                        </a>
                        <p class="text-center">
                            {!! Carbon\Carbon::parse($cartoon->publish_on)->formatLocalized('%e. %B %Y') !!}
                        </p>
                    </div>
                @endforeach
            </div>
        @endforeach
        {!! str_replace('/?', '?', $cartoons->render()) !!}
    </div>
@stop
