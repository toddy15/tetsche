@extends('layouts.app')

@section('content')
    <div class="text-center mb-4">
        <x-image :src="$image2" :width="797" :height="1122" class="img-fluid" :alt="$alt2" />
    </div>

    <div class="text-center">
        <x-image :src="$image" :width="992" :height="1063" class="img-fluid" :alt="$alt" />
    </div>
@stop
