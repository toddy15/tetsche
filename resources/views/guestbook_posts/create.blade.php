@extends('app')

@section('content')
    <h1>Gästebuch: Neuer Eintrag</h1>
    <p>Schön, dass Sie sich ins Gästebuch eintragen möchten.</p>

    {!! Form::open(['action' => 'GuestbookPostsController@store']) !!}

    <!-- Name Form Input  -->
    <div class="form-group {{ $errors->has('name') ? 'has-error has-feedback' : '' }}">
        {!! Form::label('name', 'Name:', ['class' => 'control-label']) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ihr Name', 'autofocus']) !!}
        @if ($errors->has('name'))
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
        @endif
    </div>

    <!-- Message Form Input  -->
    <div class="form-group {{ $errors->has('message') ? 'has-error has-feedback' : '' }}">
        {!! Form::label('message', 'Nachricht:', ['class' => 'control-label']) !!}
        {!! Form::textarea('message', null, ['class' => 'form-control', 'placeholder' => 'Ihre Nachricht']) !!}
        @if ($errors->has('message'))
            <span class="glyphicon glyphicon-remove form-control-feedback"></span>
        @endif
    </div>

    <!-- Submit Form Input  -->
    <div class="form-group text-center">
        {!! Form::submit('Speichern', ['class' => 'btn btn-default btn-primary']) !!}
    </div>

    {!! Form::close() !!}
@stop
