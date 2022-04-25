@extends('layouts.app')

@section('content')
    <h1 class="display-1 mb-5">Tetsche-Website</h1>

    {{-- <div class="text-center">
        <img class="img-fluid" src="{{ asset('images/hund-grinsend.jpg') }}" alt="Grinsender Hund" width="552"
             height="361"/>
    </div> --}}
    <p class="lead text-center">
        Es gibt ein neues Buch!<br>
        Alles über die sensationelle Open-Air-Ausstellung im Stader Hansehafen<br>
        ISBN 978-3-96194-173-5
    </p>
    <div class="text-center">
        <a href="https://www.kjm-buchverlag.de/produkt/tetsche-open-air/">
            <img class="img-fluid" src="{{ asset('images/open-air-buch.webp') }}" width="1024" height="690" srcset="{{ asset('images/open-air-buch-small.webp') }} 512w,
                         {{ asset('images/open-air-buch-medium.webp') }} 768w,
                         {{ asset('images/open-air-buch.webp') }} 1024w" sizes="(min-width: 1024px) 1024px, 100vw"
                alt="Buch über die Open-Air-Ausstellung in Stade" />
        </a>
    </div>
@stop
