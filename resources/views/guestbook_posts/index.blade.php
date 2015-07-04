@extends('app')

@inject('utils', 'App\TwsLib\Utils')

@section('content')
    <h1>Gästebuch</h1>
    <p><a href="{{ action('GuestbookPostsController@create') }}" class="btn btn-primary" role="button">Neuer Eintrag</a></p>
    <table class="table table-striped">
        <colgroup>
            @if (Auth::check())
                <col class="col-xs-3">
                <col class="col-xs-6">
                <col class="col-xs-3">
            @else
                <col class="col-xs-4">
                <col class="col-xs-8">
            @endif
        </colgroup>
        <thead>
            <tr>
                <th>Name</th>
                <th>Nachricht</th>
                @if (Auth::check())
                    <th>Aktion</th>
                @endif
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
                    @if (Auth::check())
                        <td>
                            {!! Form::open(array('action' => array('GuestbookPostsController@destroy', $guestbook_post->id), 'method' => 'delete')) !!}
                            <a href="{!! action('GuestbookPostsController@edit', $guestbook_post->id) !!}" class="btn btn-primary" role="button">Bearbeiten</a>
                            {!! Form::submit('Löschen', array('class' => 'btn btn-danger')) !!}
                            {!! Form::close() !!}
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
