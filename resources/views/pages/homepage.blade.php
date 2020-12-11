@extends('app')

@section('content')
    <h1 style="font-size:81px;margin-bottom:80px;">Tetsche-Website</h1>
    {{--    <h1 style="color:#fdb3b4;font-size:81px;margin-bottom:80px;">Tetsche-Website</h1>--}}
    <h2>
        Jetzt noch schnell den neuen Tetsche-Kalender kaufen:
        In jeder guten Buchhandlung erhältlich!
    </h2>
    <img class="center-block img-responsive" src="{{ asset('images/kalender.jpg') }}" alt="Tetsche-Kalender"
         title="Tetsche-Kalender" width="700" height="863"/>
@stop
