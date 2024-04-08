@extends('layouts.app')

@section('content')
    <h1>Ausstellungen: Eintrag bearbeiten</h1>

    <form method="POST" action="{{ route('ausstellungen.update', $exhibition) }}">
        @csrf
        @method('PUT')

        @include('exhibitions.form')

        <div class="text-center">
            <input type="submit" class="btn btn-default btn-primary" value="Speichern">
        </div>
    </form>

    <form method="POST" action="{{ route('ausstellungen.destroy', $exhibition) }}">
        @csrf
        @method('DELETE')
        <input type="submit" class="btn btn-danger" value="Löschen">
    </form>
@stop
