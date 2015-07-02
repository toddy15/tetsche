@extends('app')

@section('content')
    <h1>Gästebuch: Eintrag bearbeiten</h1>

    {!! Form::model($guestbook_post, ['method' => 'PUT', 'action' => ['GuestbookPostsController@update', $guestbook_post->id]]) !!}

    @include('guestbook_posts.form')

    <!-- Submit Form Input  -->
    <div class="form-group text-center">
        {!! Form::submit('Speichern', ['class' => 'btn btn-default btn-primary']) !!}
    </div>

    {!! Form::close() !!}
@stop
