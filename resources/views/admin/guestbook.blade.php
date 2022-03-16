@extends('layouts.app')

@section('content')
    <h1>Administration des Gästebuchs</h1>
    <p>
        Hier können Beiträge angezeigt werden, die eine entsprechende Zuordnung haben.
    </p>

    <div class="list-group">
        <a class="list-group-item list-group-item-action"
           href="{{ action([App\Http\Controllers\SpamController::class, 'showPosts'], ['manual_ham']) }}">Manuell als
            Ham gelernt</a>
        <a class="list-group-item list-group-item-action"
           href="{{ action([App\Http\Controllers\SpamController::class, 'showPosts'], ['unsure']) }}">Keine
            Zuordnung</a>
        <a class="list-group-item list-group-item-action"
           href="{{ action([App\Http\Controllers\SpamController::class, 'showPosts'], ['manual_spam']) }}">Manuell als
            Spam gelernt</a>
        <a class="list-group-item list-group-item-action"
           href="{{ action([App\Http\Controllers\SpamController::class, 'showPosts'], ['autolearn_ham']) }}">Automatisch
            als Ham gelernt</a>
        <a class="list-group-item list-group-item-action"
           href="{{ action([App\Http\Controllers\SpamController::class, 'showPosts'], ['autolearn_spam']) }}">Automatisch
            als Spam gelernt</a>
    </div>
    {{--
    @TODO: The relearning has not work correctly for ages.
    <p>
        Mit diesem Knopf werden alle Texte neu analysiert. Das ist etwas zeitaufwändig.
    </p>
    <div class="row">
        <div class="col-4">
            <a href="{{ action([App\Http\Controllers\SpamController::class, 'relearn']) }}" class="btn btn-primary btn-block">Alle Einträge neu lernen</a>
        </div>
    </div>
    --}}
@stop
