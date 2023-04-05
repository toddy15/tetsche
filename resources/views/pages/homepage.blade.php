@extends('layouts.app')

@section('content')
    <div class="text-center">
        <x-image :src="$src" :width="$width" :height="$height" class="img-fluid" />
    </div>
@stop
