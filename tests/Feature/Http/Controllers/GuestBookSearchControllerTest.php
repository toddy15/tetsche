<?php

declare(strict_types=1);

use function Pest\Laravel\get;

it('redirects for an empty query', function () {
    get('gaestebuch/suche')
        ->assertRedirect(route('gaestebuch.index'));
});

it('returns ok for a query', function () {
    get('gaestebuch/suche?q=SEARCH')
        ->assertOk()
        ->assertViewIs('guestbook_posts.index')
        ->assertViewHas('guestbook_posts')
        ->assertViewHas('title')
        ->assertViewHas('description')
        ->assertViewHas('pagetitle')
        ->assertViewHas('query');
});

it('returns correct results for a query');
