@extends('layouts.app')

@section('content')
    <h1 class="display-1 mb-5">Tetsche-Website</h1>

    <div class="text-center">
        <x-image :src="$image_name" class="img-fluid" />
    </div>
@stop
