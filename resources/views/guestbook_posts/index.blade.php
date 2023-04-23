@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 col-sm-8">
            <h1>{{ $pagetitle ?? $title }}</h1>
            <div class="row">
                <div class="col-12 col-sm-6">
                    <p><a href="{{ route('gaestebuch.create') }}"
                          class="btn btn-primary" role="button">Neuer Eintrag</a></p>
                </div>
                <div class="col-12 col-sm-6">
                    <form method="GET"
                          action="{{ action(App\Http\Controllers\GuestBookSearchController::class) }}">
                        <div class="form-inline">
                            <label class="visually-hidden form-label" for="search">Suche:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="search" name="q" placeholder="Suche …">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor"
                                             class="bi bi-search" viewBox="0 0 16 16">
                                            <path
                                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                        </svg>
                                        <span class="visually-hidden">Suchen</span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-4 text-end">
            {!! $image !!}
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="col-4">Name</th>
            <th class="col-8">Nachricht</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($guestbook_posts as $guestbook_post)
            <tr>
                <td>
                    {{ $guestbook_post->name }}<br />
                    <span>{{ $guestbook_post->created_at->locale('de')->isoFormat('Do MMMM YYYY, HH:mm') }}</span>
                </td>
                <td>
                    <p>
                        {!! $guestbook_post->message !!}
                    </p>
                    @if ($guestbook_post->cheffe)
                        <p class="text-danger">{!! $guestbook_post->cheffe !!}</p>
                    @endif
                    @auth
                        <form method="POST" action="{{ route('gaestebuch.destroy', $guestbook_post) }}">
                            @csrf
                            @method('delete')
                            <a href="{!! route('gaestebuch.edit', $guestbook_post) !!}" class="btn btn-primary">Bearbeiten</a>
                            <input type="submit" class="btn btn-danger" value="Löschen">
                        </form>
                    @endauth
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        @empty($query)
            {{ $guestbook_posts->links() }}
        @else
            {{ $guestbook_posts->appends(['q' => $query])->links() }}
        @endif
    </div>
@stop
