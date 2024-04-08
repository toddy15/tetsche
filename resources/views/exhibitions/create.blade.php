@extends('layouts.app')

@section('content')
    <h1>Ausstellungen: Neuer Eintrag</h1>

    <form method="POST" action="{{ route('ausstellungen.store') }}">
        @csrf

        @include('exhibitions.form')

        <div class="text-center">
            <button type="submit" class="btn btn-default btn-primary">Speichern</button>
        </div>
    </form>
@stop
