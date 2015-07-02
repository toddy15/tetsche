@extends('app')

@section('content')
    <h1>Gästebuch: Neuer Eintrag</h1>
    <p>Schön, dass Sie sich ins Gästebuch eintragen möchten.</p>

    {!! Form::open(['action' => 'GuestbookPostsController@store']) !!}

    @include('guestbook_posts.form')

    <!-- Submit Form Input  -->
    <div class="form-group text-center">
        {!! Form::submit('Speichern', ['class' => 'btn btn-default btn-primary']) !!}
    </div>

    {!! Form::close() !!}
@stop
