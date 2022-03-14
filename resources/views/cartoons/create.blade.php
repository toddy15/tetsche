@extends('layouts.app')

@section('content')
    <h1>Neuer Cartoon</h1>

    {!! Form::open(['url' => action([App\Http\Controllers\CartoonsController::class, 'store']), 'files' => true]) !!}

    <div class="form-inline">
        {!! Form::label('day', 'Tag der Veröffentlichung:', ['class' => 'control-label']) !!}
        {!! Form::selectRange('day', 1, 31, $day, ['class' => 'form-control']) !!}
        {!! Form::label('month', 'Monat der Veröffentlichung:', ['class' => 'sr-only']) !!}
        {!! Form::selectMonth('month', $month, ['class' => 'form-control']) !!}
        {!! Form::label('year', 'Jahr der Veröffentlichung:', ['class' => 'sr-only']) !!}
        {!! Form::selectRange('year', $year - 1, $year + 1, $year, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('image', 'Cartoon:', ['class' => 'control-label']) !!}
        {!! Form::file('image', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('rebus', 'Lösung für den Rebus:', ['class' => 'control-label']) !!}
        {!! Form::text('rebus', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Speichern', ['class' => 'btn btn-default btn-primary']) !!}
    </div>

    {!! Form::close() !!}
@stop
