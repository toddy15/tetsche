Wahrscheinlichkeit für Spam: {{ round($guestbook_post->score * 100, 1) }}%
Kategorie: {{ $guestbook_post->category }}
Identifikation: {!! $guestbook_post->spam_detection !!}

{!! $guestbook_post->name !!}

{!! $guestbook_post->message !!}

Bearbeiten: {!! route('gästebuch.edit', ['gästebuch' => $guestbook_post]) !!}
