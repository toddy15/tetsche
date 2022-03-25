@extends('layouts.app')

@section('content')
    <h1>Cartoon bearbeiten</h1>
    <h2>{{ \Carbon\Carbon::parse($date->publish_on)->locale('de')->isoFormat('Do MMMM YYYY') }}</h2>

    <img class="d-block mx-auto img-fluid"
         src="{{ asset($date->cartoon->imagePath()) }}" {!! $date->cartoon->imageSizeAndDescription() !!} />

    <form method="POST" action="{{ route('publication_dates.update', $date) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="form-label" for="rebus">Rebuslösung:</label>
            <input type="text" class="form-control" id="rebus" name="rebus"
                   placeholder="Rebuslösung" value="{{ old("rebus") ?? $date->cartoon->rebus ?? '' }}">
        </div>

        <input type="submit" class="btn btn-primary" value="Speichern"/>
    </form>
@stop