@extends('app')

@section('content')
    <h1>Gästebuch: Neuer Eintrag</h1>
    <p>Schön, dass Sie sich ins Gästebuch eintragen möchten.</p>

    {!! Form::open(['action' => 'GuestbookPostsController@store']) !!}

    <!-- Name Form Input  -->
    <div class="form-group">
        {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ihr Name', 'autofocus']) !!}
    </div>

    <!-- Message Form Input  -->
    <div class="form-group">
        {!! Form::label('message', 'Nachricht:') !!}
        {!! Form::textarea('message', null, ['class' => 'form-control', 'placeholder' => 'Ihre Nachricht']) !!}
    </div>

    <!-- Submit Form Input  -->
    <div class="form-group text-center">
        {!! Form::submit('Speichern', ['class' => 'btn btn-default btn-primary']) !!}
    </div>
    {!! Form::close() !!}
@stop
