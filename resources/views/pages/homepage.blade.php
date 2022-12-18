@extends('layouts.app')

@section('content')
    <h1 class="display-1 mb-5">Tetsche-Website</h1>

    <div class="text-center">
        <img class="img-fluid" src="{{ asset("images/$image_name") }}" alt="Bonzo, der Hund" width="900"
             height="600" />
    </div>
@stop
