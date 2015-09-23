@extends('app')

@inject('utils', 'App\TwsLib\Utils')
@inject('images', 'App\TwsLib\Images')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <h1>{{ $pagetitle or $title }}</h1>
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <p><a href="{{ action('GuestbookPostsController@create') }}" class="btn btn-primary" role="button">Neuer Eintrag</a></p>
                </div>
                <div class="col-xs-12 col-sm-6">
                    {!! Form::open(['action' => 'GuestbookPostsController@search', 'method' => 'GET', 'class' => 'form-inline']) !!}
                    <div class="form-inline">
                        {!! Form::label('search', 'Suche:', ['class' => 'sr-only control-label']) !!}
                        <div class="input-group">
                            {!! Form::input('search', 'q', null, ['class' => 'form-control', 'size' => 30, 'placeholder' => 'Suche ...']) !!}
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4 text-right">
            {!! $images->getRandomImageForGuestbook() !!}
        </div>
    </div>
    @if ($guestbook_posts->count())
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
                            @if (Auth::check())
                                {!! Form::open(array('action' => array('GuestbookPostsController@destroy', $guestbook_post->id), 'method' => 'delete')) !!}
                                <a href="{!! action('GuestbookPostsController@edit', $guestbook_post->id) !!}" class="btn btn-primary" role="button">Bearbeiten</a>
                                {!! Form::submit('Löschen', array('class' => 'btn btn-danger')) !!}
                                {!! Form::close() !!}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if (isset($query))
            {!! str_replace('/?', '?', $guestbook_posts->appends(['q' => $query])->render()) !!}
        @else
            {!! str_replace('/?', '?', $guestbook_posts->render()) !!}
        @endif
    @else
        <p>
            Keine Einträge gefunden.
        </p>
    @endif
@stop
