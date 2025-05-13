@extends('layouts.app')

@section('content')
    <div class="text-center">
        <x-image :src="$image" :width="992" :height="1063" class="img-fluid" :alt="$alt" />
    </div>
@stop
