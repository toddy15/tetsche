@props(['src', 'width', 'height', 'alt' => ''])

<img src="{{ asset($src) }}" width="{{ $width }}" height="{{ $height }}" alt="{{ $alt }}"
    {{ $attributes }} />
