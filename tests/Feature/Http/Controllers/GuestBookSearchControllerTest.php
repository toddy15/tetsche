<?php

declare(strict_types=1);

use App\Models\GuestbookPost;

it('redirects without a query', function () {
    $this->get('gaestebuch/suche')
        ->assertRedirect(route('gaestebuch.index'));
});

it('redirects for an empty query', function () {
    $this->get('gaestebuch/suche?q=')
        ->assertRedirect(route('gaestebuch.index'));
});

it('returns ok for a query', function () {
    $this->get('gaestebuch/suche?q=SEARCH')
        ->assertOk()
        ->assertViewIs('guestbook_posts.index')
        ->assertViewHas('guestbook_posts')
        ->assertViewHas('title')
        ->assertViewHas('description')
        ->assertViewHas('pagetitle')
        ->assertViewHas('query');
});

it('returns correct results for a query', function () {
    // Set up two different entries
    GuestbookPost::factory()->create(['message' => 'First Post']);
    GuestbookPost::factory()->create(['message' => 'Second Post']);

    // Without search, both posts should be visible
    $this->get('gaestebuch')
        ->assertOk()
        ->assertSeeText('First Post')
        ->assertSeeText('Second Post');

    // With search, only the second post should be visible
    $this->get('gaestebuch/suche?q=second')
        ->assertOk()
        ->assertDontSeeText('First Post')
        ->assertSeeText('Second Post');
});
