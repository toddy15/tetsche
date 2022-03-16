@extends('layouts.app')

@section('content')
    <h1>Gästebuch: Eintrag bearbeiten</h1>

    {!! Form::model($guestbook_post, ['method' => 'PUT', 'action' => ['GuestbookPostsController@update', $guestbook_post->id]]) !!}

    @include('guestbook_posts.form')

    <!-- Cheffe Form Input  -->
    <div class="form-group">
        {!! Form::label('cheffe', 'Cheffe:') !!}
        {!! Form::textarea('cheffe', null, ['class' => 'form-control', 'placeholder' => 'Cheffes Kommentar']) !!}
    </div>

    <!-- Spam determination -->
    <div class="form-group">
        {!! Form::label('score', 'Wahrscheinlichkeit für Spam:', ['class' => 'control-label']) !!}
        <p class="form-control-static">{!! $guestbook_post->score !!}%</p>
    </div>

    <div class="form-group">
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
    <div class="form-group text-center">
        {!! Form::submit('Speichern', ['class' => 'btn btn-default btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    <div class="form-group text-center">
        {!! Form::open(['action' => [[GuestbookPostsController::class, 'destroy'], $guestbook_post->id], 'method' => 'delete']) !!}
        {!! Form::submit('Löschen', ['class' => 'btn btn-danger']) !!}
        {!! Form::close() !!}
    </div>
@stop
