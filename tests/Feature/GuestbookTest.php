<?php

use App\Models\GuestbookPost;
use App\Models\PublicationDate;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

test('a guest can view the guestbook page', function () {
    // Ensure there are entries
    GuestbookPost::factory()
        ->count(5)
        ->create();

    get(route('gaestebuch.index'))
        ->assertOk()
        ->assertSeeText('Gästebuch')
        ->assertSeeText('Name')
        ->assertSeeText('Nachricht');
});

test('a guest can post a new entry', function () {
    // Ensure there are entries
    GuestbookPost::factory()
        ->count(5)
        ->create();

    // There has to be at least one PublicationDate for the rebus spamcheck.
    PublicationDate::factory()->create();

    get(route('gaestebuch.create'))
        ->assertOk()
        ->assertSeeText('Gästebuch: Neuer Eintrag');

    $entry = GuestbookPost::factory()->raw([
        'cheffe' => null,
        'category' => 'unsure',
        'spam_detection' => 'IP: 127.0.0.1, Browser: Symfony',
    ]);
    $this->assertDatabaseMissing('guestbook_posts', $entry);

    post(route('gaestebuch.store'), $entry)->assertRedirect();

    $this->assertDatabaseHas('guestbook_posts', $entry);

    get(route('gaestebuch.index'))
        ->assertSeeText($entry['name'])
        ->assertSeeText($entry['message']);
});
