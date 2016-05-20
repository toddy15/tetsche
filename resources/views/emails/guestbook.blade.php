Wahrscheinlichkeit für Spam: {{ round($score * 100, 1) }}%
Kategorie: {{ $category }}
Identifikation: {!! $spam_detection !!}

{!! $name !!}

{!! $body !!}

Bearbeiten: {!! action('GuestbookPostsController@edit', ['id' => $id]) !!}
