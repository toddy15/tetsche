@extends('layouts.app')

@section('content')
    <h1>Ausstellungen</h1>

    @forelse($exhibitions as $exhibition)
        {{ $exhibition->title }}<br>
    @empty
        <p>
            Aktuell findet keine Ausstellung statt.
        </p>
    @endforelse
@stop
