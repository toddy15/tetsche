<?php

declare(strict_types=1);

use App\Models\GuestbookPost;
use App\Models\PublicationDate;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Spatie\PestPluginTestTime\testTime;

beforeEach(function () {
    $dates = [
        '2021-11-18',
        '2021-11-25', // not available anymore
        '2021-12-02', // oldest date in the archive
        '2021-12-09',
        '2021-12-16',
        '2021-12-23',
        '2021-12-30',
        '2022-01-06',
        '2022-01-13',
        '2022-01-20',
        '2022-01-27',
        '2022-02-03',
        '2022-02-10',
        '2022-02-17',
        '2022-02-24',
        '2022-03-03',
        '2022-03-10',
        '2022-03-17', // newest date in the archive
        '2022-03-24', // current
        '2022-03-31', // future cartoon
    ];

    foreach ($dates as $date) {
        PublicationDate::factory()->create(['publish_on' => $date]);
    }

    testTime()->freeze('2022-03-26 14:30:00');
});

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

    get(route('gaestebuch.create'))
        ->assertOk()
        ->assertSeeText('Gästebuch: Neuer Eintrag');

    $entry = GuestbookPost::factory()->raw([
        'cheffe' => null,
        'category' => 'unsure',
        'spam_detection' => 'IP: 127.0.0.1, Browser: Symfony',
    ]);
    $this->assertDatabaseMissing('guestbook_posts', $entry);

    post(route('gaestebuch.store'), $entry)
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseHas('guestbook_posts', $entry);

    get(route('gaestebuch.index'))
        ->assertSeeText($entry['name'])
        ->assertSeeText($entry['message']);
});

test('an entry must have a name', function () {
    $entry = GuestbookPost::factory()->raw([
        'name' => '',
        'cheffe' => null,
        'category' => 'unsure',
        'spam_detection' => 'IP: 127.0.0.1, Browser: Symfony',
    ]);
    $this->assertDatabaseMissing('guestbook_posts', $entry);

    post(route('gaestebuch.store'), $entry)
        ->assertSessionHasErrors(['name']);

    $this->assertDatabaseMissing('guestbook_posts', $entry);
});

test('an entry must have a message', function () {
    $entry = GuestbookPost::factory()->raw([
        'message' => '',
        'cheffe' => null,
        'category' => 'unsure',
        'spam_detection' => 'IP: 127.0.0.1, Browser: Symfony',
    ]);
    $this->assertDatabaseMissing('guestbook_posts', $entry);

    post(route('gaestebuch.store'), $entry)
        ->assertSessionHasErrors(['message']);

    $this->assertDatabaseMissing('guestbook_posts', $entry);
});
