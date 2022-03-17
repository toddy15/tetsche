@extends('layouts.app')

@section('content')
    <h1>Gästebuch: Eintrag bearbeiten</h1>

    {!! Form::model($guestbook_post, ['method' => 'PUT', 'route' => ['gaestebuch.update', $guestbook_post->id]]) !!}

    @include('guestbook_posts.form')

    <div class="mb-4">
    <label class="form-label" for="cheffe">Cheffe:</label>
    <textarea class="form-control" id="cheffe" name="cheffe"
              placeholder="Cheffes Kommentar" rows="10"
              cols="50">{{ old("cheffe") }}</textarea>
    </div>

    <div class="mb-4">
        {!! Form::label('score', 'Wahrscheinlichkeit für Spam:', ['class' => 'control-label']) !!}
        <p class="form-control-static">{!! $guestbook_post->score !!}%</p>
    </div>

    <div class="mb-4">
        {!! Form::label('category', 'Kategorie:', array('class' => 'control-label')) !!}
        {!! Form::select('category', [
            'manual_ham' => 'Akzeptieren',
            'unsure' => 'Keine Zuordnung',
            'manual_spam' => 'Als Spam ablehnen',
            '-' => '------',
            'ham' => 'Automatisch akzeptiert',
            'autolearn_ham' => 'Automatisch akzeptiert und gelernt',
            'autolearn_spam' => 'Automatisch als Spam gelernt',
        ], $guestbook_post->category) !!}
    </div>

    <!-- Submit Form Input  -->
    <div class="text-center">
        {!! Form::submit('Speichern', ['class' => 'btn btn-default btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    <div class="text-center">
        {!! Form::open(['route' => ['gaestebuch.destroy', $guestbook_post->id], 'method' => 'delete']) !!}
        {!! Form::submit('Löschen', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
@stop
