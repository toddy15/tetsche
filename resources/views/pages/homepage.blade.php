@extends('layouts.app')

@section('content')
    <h1 class="display-1 mb-5">Tetsche-Website</h1>

    <div class="text-center">
        @if ($image_name == "bonzo-ball.webp")
            <img class="img-fluid" src="{{ asset("images/$image_name") }}" alt="Bonzo, der Hund" width="1195"
                 height="600" />
        @else
            <img class="img-fluid" src="{{ asset("images/$image_name") }}" alt="Bonzo, der Hund" width="900"
                 height="600" />
        @endif
    </div>
@stop
