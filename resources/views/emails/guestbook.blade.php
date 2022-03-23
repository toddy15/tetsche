Wahrscheinlichkeit für Spam: {{ round($guestbook_post->score * 100, 1) }}%
Kategorie: {{ $guestbook_post->category }}
Identifikation: {!! $guestbook_post->spam_detection !!}

{!! $guestbook_post->name !!}

{!! $guestbook_post->message !!}

@isset($guestbook_post->id)
Bearbeiten: {!! route('gaestebuch.edit', $guestbook_post) !!}
@endisset
