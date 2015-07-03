@extends('app')

@inject('utils', 'App\TwsLib\Utils')

@section('content')
    <h1>Gästebuch</h1>
    <p><a href="{{ action('GuestbookPostsController@create') }}" class="btn btn-primary" role="button">Neuer Eintrag</a></p>
    <table class="table table-striped">
        <colgroup>
            <col class="col-xs-4">
            <col class="col-xs-8">
        </colgroup>
        <thead>
            <tr>
                <th>Name</th>
                <th>Nachricht</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guestbook_posts as $guestbook_post)
            <tr>
                <td>
                    {{ $guestbook_post->name }}<br />
                    <span>{{ $guestbook_post->created_at->formatLocalized('%e. %B %Y, %H:%M') }}</span>
                </td>
                <td>
                    <p>
                        {!! $utils->replaceSmileys($guestbook_post->message) !!}
                    </p>
                    @if ($guestbook_post->cheffe)
                        <p class="text-danger">{!! $utils->replaceSmileys($guestbook_post->cheffe) !!}</p>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@stop
