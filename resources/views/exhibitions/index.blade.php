@extends('layouts.app')

@section('content')
    <h1>Ausstellungen</h1>

    @forelse($exhibitions as $exhibition)
        <div class="text-center">
            <h2>{{ $exhibition->title }}</h2>
            <div>
                {{ $exhibition->description }}
            </div>
            <img src="{{ asset($exhibition->image) }}" class="img-fluid" width="{{ $exhibition->image_width }}"
                height="{{ $exhibition->image_height }}" alt="Bild der Ausstellung" />
        </div>
    @empty
        <p>
            Aktuell findet keine Ausstellung statt.
        </p>
    @endforelse
@stop
