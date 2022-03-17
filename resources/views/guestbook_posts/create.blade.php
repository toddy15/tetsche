@extends('layouts.app')

@section('content')
    <h1>Gästebuch: Neuer Eintrag</h1>
    <p>Schön, dass Sie sich ins Gästebuch eintragen möchten.</p>

    <form method="POST" action="{{ route('gaestebuch.store') }}">
        @csrf

        @include('guestbook_posts.form')

        <div class="text-center">
            <button type="submit" class="btn btn-default btn-primary">Speichern</button>
        </div>
    </form>
@stop
