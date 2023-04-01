@props(['src', 'alt' => ''])

@php
    $width = getimagesize($src)[0];
    $height = getimagesize($src)[1];
@endphp

<img src="{{ asset($src) }}" width="{{ $width }}" height="{{ $height }}" alt="{{ $alt }}" {{ $attributes }} />
