@extends('app')

@section('content')
    <div class="jumbotron alert-danger">
        <h1>Seite nicht vorhanden</h1>
        @foreach ($msg_lines as $msg_line)
            <p>{{ $msg_line }}</p>
        @endforeach
    </div>
@stop
