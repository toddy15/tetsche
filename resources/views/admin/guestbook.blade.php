@extends('app')

@section('content')
    <h1>Administration des Gästebuchs</h1>
    <p>
        Hier können Beiträge angezeigt werden, die eine entsprechende Zuordnung haben.
    </p>

    <div class="container">
        <a href="{{ action('SpamController@showPosts', ['manual_ham']) }}" class="btn btn-primary">Manuell als Ham gelernt</a>
        <a href="{{ action('SpamController@showPosts', ['unsure']) }}" class="btn btn-primary">Keine Zuordnung</a>
        <a href="{{ action('SpamController@showPosts', ['manual_spam']) }}" class="btn btn-primary">Manuell als Spam gelernt</a>
        <a href="{{ action('SpamController@showPosts', ['autolearn_ham']) }}" class="btn btn-primary">Automatisch als Ham gelernt</a>
        <a href="{{ action('SpamController@showPosts', ['autolearn_spam']) }}" class="btn btn-primary">Automatisch als Spam gelernt</a>
    </div>
<!--
    <p><a href="{{ action('SpamController@showPosts', ['manual_ham']) }}" class="btn btn-primary">Manuell als Ham gelernt</a></p>
    <p><a href="{{ action('SpamController@showPosts', ['unsure']) }}" class="btn btn-primary">Keine Zuordnung</a></p>
    <p><a href="{{ action('SpamController@showPosts', ['manual_spam']) }}" class="btn btn-primary">Manuell als Spam gelernt</a></p>
    <p><a href="{{ action('SpamController@showPosts', ['autolearn_ham']) }}" class="btn btn-primary">Automatisch als Ham gelernt</a></p>
    <p><a href="{{ action('SpamController@showPosts', ['autolearn_spam']) }}" class="btn btn-primary">Automatisch als Spam gelernt</a></p>
    -->
    <p>
        Mit diesem Knopf werden alle Texte neu analysiert. Das ist etwas zeitaufwändig.
    </p>
    <p><a href="{{ action('SpamController@relearn') }}" class="btn btn-primary">Alle Einträge neu lernen</a></p>
@stop
