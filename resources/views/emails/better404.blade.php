Hallo,

@if ($origin == 'own_website')
Es gibt einen fehlerhaften Link auf der Tetsche-Website.
@elseif ($origin == 'search_engine')
Es gibt einen fehlerhaften Link bei einer Suchmaschine.
@elseif ($origin == 'other_website')
Es gibt einen fehlerhaften Link auf einer anderen Website.
@else
Es gibt einen fehlerhaften Link sonstwo.
Diese Nachricht darf eigentlich nicht kommen.
@endif

Referer: {{ $referer }}
Requested URI: {{ $requested_uri }}
