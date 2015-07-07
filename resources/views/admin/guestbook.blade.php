@extends('app')

@section('content')
    <h1>Administration des Gästebuchs</h1>
    <p>
        Hier können Beiträge angezeigt werden, die eine entsprechende Zuordnung haben.
    </p>

    <div class="row">
        <div class="col-sm-4">
            <a href="{{ action('SpamController@showPosts', ['manual_ham']) }}" class="btn btn-primary btn-block">Manuell als Ham gelernt</a>
            <a href="{{ action('SpamController@showPosts', ['unsure']) }}" class="btn btn-primary btn-block">Keine Zuordnung</a>
            <a href="{{ action('SpamController@showPosts', ['manual_spam']) }}" class="btn btn-primary btn-block">Manuell als Spam gelernt</a>
            <a href="{{ action('SpamController@showPosts', ['autolearn_ham']) }}" class="btn btn-primary btn-block">Automatisch als Ham gelernt</a>
            <a href="{{ action('SpamController@showPosts', ['autolearn_spam']) }}" class="btn btn-primary btn-block">Automatisch als Spam gelernt</a>
        </div>
    </div>
    <p>
        Mit diesem Knopf werden alle Texte neu analysiert. Das ist etwas zeitaufwändig.
    </p>
    <div class="row">
        <div class="col-sm-4">
            <a href="{{ action('SpamController@relearn') }}" class="btn btn-primary btn-block">Alle Einträge neu lernen</a>
        </div>
    </div>
@stop
