@extends('layouts.app')

@section('content')
    <div class="text-center">
        <x-image :src="$initial_image" :width="1296" :height="1296" class="img-fluid" />
        <x-image :src="$src" :width="$width" :height="$height" class="img-fluid" />
    </div>
@stop
