
<ul>
@foreach ($guestbook_posts as $guestbook_post)
    <li>{{ $guestbook_post->name }}</li>
@endforeach
</ul>
