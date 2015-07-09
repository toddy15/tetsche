Wahrscheinlichkeit für Spam: {{ round($score * 100, 1) }}%
Kategorie: {{ $category }}

{!! $name !!}

{!! $body !!}

Bearbeiten: {!! action('GuestbookPostsController@edit', ['id' => $id]) !!}
