@extends('app')

@section('content')
    <h1 style="color:#fdb3b4;font-size:81px;margin-bottom:80px;">Tetsche-Website</h1>
    <h2 class="text-center" style="color:#fdb3b4">Deutscher Cartoonpreis 2017</h2>
    <p class="text-center">
        Tetsche gewinnt den Deutschen Cartoonpreis 2017
        auf der Frankfurter Buchmesse!
    </p>
    <p class="text-center">
        1. Platz: Tetsche<br />
        2. Platz: Duo Hauck / Bauer<br />
        3. Platz: Katharina Greve
    </p>
    <img class="center-block img-responsive" src="{{ asset('images/siegerehrung.jpg') }}" alt="Siegerehrung" title="Siegerehrung" width="808" height="639" />
    <h3 class="text-center" style="color:#fdb3b4">Der Siegercartoon</h3>
    <img style="margin-bottom:50px;" class="center-block img-responsive" src="{{ asset('images/america-first.jpg') }}" alt="America first" title="America first" width="780" height="886" />
@stop
