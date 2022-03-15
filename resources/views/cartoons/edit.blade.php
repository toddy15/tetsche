@extends('layouts.app')

@section('content')
    <h1>Cartoon bearbeiten</h1>

    <img class="text-center img-fluid" src="{!! asset($cartoon->imagePath()) !!}" {!! $cartoon->imageSizeAndDescription() !!} />

    {!! Form::model($cartoon, ['action' => [[App\Http\Controllers\CartoonsController::class, 'update'], $cartoon->id], 'method' => 'PUT']) !!}

    <div class="form-group">
        {!! Form::label('rebus', 'Lösung für den Rebus:', ['class' => 'control-label']) !!}
        {!! Form::text('rebus', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Speichern', ['class' => 'btn btn-default btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    {!! Form::open(['action' => [[App\Http\Controllers\CartoonsController::class, 'destroy'], $cartoon->id], 'method' => 'DELETE']) !!}
    {!! Form::submit('Cartoon löschen', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop
