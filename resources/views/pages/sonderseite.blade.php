@extends('layouts.app')

@section('content')
    <h1>
        Weihnachtskugel für einen guten Zweck
    </h1>
    <p>
        Tetsche unterstützt das »<a href="https://hospiz-elbe-weser.de/">Hospiz zwischen Elbe und Weser</a>«
        mit einer Weihnachtskugel!
    </p>
    <p>
        Das Geld aus dieser Charity-Aktion geht zu 100 % an das
        Hospiz.
    </p>
    <p>
        Jetzt für nur 4,95 € bei
        <a href="https://chari-christmas.de/produkt/christbaumkugel-tetsche/">Chari-Christmas</a>
        kaufen!
    </p>
    <div class="text-center">
        <a href="https://chari-christmas.de/produkt/christbaumkugel-tetsche/">
            <x-image :src="$image" :width="640" :height="448" class="img-fluid" :alt="$alt" />
        </a>
    </div>
@stop
