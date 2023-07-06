@extends('layouts.app')

@section('content')
    <h1>Gästebuch: Eintrag bearbeiten</h1>

    <form method="POST" action="{{ route('gaestebuch.update', $guestbook_post) }}">
        @csrf
        @method('PUT')

        @include('guestbook_posts.form')

        <div class="mb-4">
            <label class="form-label" for="cheffe">Cheffe:</label>
            <textarea class="form-control" id="cheffe" name="cheffe" placeholder="Cheffes Kommentar" rows="10" cols="50">{{ old('cheffe') ?? $guestbook_post->cheffe }}</textarea>
        </div>

        <div class="mb-4">
            <label class="form-label" for="score">Wahrscheinlichkeit für Spam:</label>
            <input type="text" readonly class="form-control-plaintext" id="score" value="{!! $guestbook_post->score !!}%">
        </div>

        <div class="mb-4">
            <label class="form-label" for="category">Kategorie:</label>
            <select class="form-select" aria-label="Kategorie des Posts" id="category" name="category">
                <option value="no_autolearn_h" @selected(old('category', $guestbook_post->category) == 'no_autolearn_h')>Automatisch akzeptiert</option>
                <option value="manual_ham" @selected(old('category', $guestbook_post->category) == 'manual_ham')>Akzeptieren</option>
                <option value="unsure" @selected(old('category', $guestbook_post->category) == 'unsure')>Keine Zuordnung</option>
                <option value="manual_spam" @selected(old('category', $guestbook_post->category) == 'manual_spam')>Als Spam ablehnen</option>
                <option value="-" @selected(old('category', $guestbook_post->category) == '-')>-</option>
                <option value="autolearn_ham" @selected(old('category', $guestbook_post->category) == 'autolearn_ham')>Automatisch akzeptiert und gelernt</option>
                <option value="autolearn_spam" @selected(old('category', $guestbook_post->category) == 'autolearn_spam')>Automatisch als Spam gelernt</option>
            </select>
        </div>

        <div class="text-center">
            <input type="submit" class="btn btn-default btn-primary" value="Speichern">
        </div>
    </form>

    <form method="POST" action="{{ route('gaestebuch.destroy', $guestbook_post) }}">
        @csrf
        @method('DELETE')
        <input type="submit" class="btn btn-danger" value="Löschen">
    </form>
@stop
