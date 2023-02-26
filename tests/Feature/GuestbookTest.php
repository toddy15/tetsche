<?php

declare(strict_types=1);

use App\Models\GuestbookPost;
use App\Models\PublicationDate;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;
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

test('a guest cannot edit an entry', function () {
    $guestbookPost = GuestbookPost::factory()->create();

    get(route('gaestebuch.edit', ['gaestebuch' => $guestbookPost]))
        ->assertRedirect(route('login'));

    $this->assertModelExists($guestbookPost);
});

test('a guest cannot update an entry', function () {
    $guestbookPost = GuestbookPost::factory()->create();
    expect($guestbookPost->name)->not()->toBe('XX-NEW-NAME-XX');
    expect($guestbookPost->message)->not()->toBe('XX-NEW-MESSAGE-XX');
    expect($guestbookPost->category)->not()->toBe('spam');

    put(route('gaestebuch.update', ['gaestebuch' => $guestbookPost]), [
        'name' => 'XX-NEW-NAME-XX',
        'message' => 'XX-NEW-MESSAGE-XX',
        'category' => 'spam',
    ])
        ->assertRedirect(route('login'));

    $guestbookPost->refresh();

    expect($guestbookPost->name)->not()->toBe('XX-NEW-NAME-XX');
    expect($guestbookPost->message)->not()->toBe('XX-NEW-MESSAGE-XX');
    expect($guestbookPost->category)->not()->toBe('spam');
});

test('a guest cannot destroy an entry', function () {
    $guestbookPost = GuestbookPost::factory()->create();
    $this->assertModelExists($guestbookPost);

    delete(route('gaestebuch.destroy', ['gaestebuch' => $guestbookPost]))
        ->assertRedirect(route('login'));

    $this->assertModelExists($guestbookPost);
});

test('a user can edit an entry', function () {
    actingAs(User::factory()->create());

    $guestbookPost = GuestbookPost::factory()->create();

    get(route('gaestebuch.edit', ['gaestebuch' => $guestbookPost]))
        ->assertOk()
        ->assertViewIs('guestbook_posts.edit')
        ->assertViewHas('guestbook_post');
});

test('a user can update an entry', function () {
    actingAs(User::factory()->create());

    $guestbookPost = GuestbookPost::factory()->create();
    expect($guestbookPost->name)->not()->toBe('XX-NEW-NAME-XX');
    expect($guestbookPost->message)->not()->toBe('XX-NEW-MESSAGE-XX');
    expect($guestbookPost->category)->not()->toBe('spam');

    put(route('gaestebuch.update', ['gaestebuch' => $guestbookPost]), [
        'name' => 'XX-NEW-NAME-XX',
        'message' => 'XX-NEW-MESSAGE-XX',
        'category' => 'spam',
    ])
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('gaestebuch.index'));

    $guestbookPost->refresh();

    expect($guestbookPost->name)->toBe('XX-NEW-NAME-XX');
    expect($guestbookPost->message)->toBe('XX-NEW-MESSAGE-XX');
    expect($guestbookPost->category)->toBe('spam');
});

test('a user can destroy an entry', function () {
    actingAs(User::factory()->create());

    $guestbookPost = GuestbookPost::factory()->create();
    $this->assertModelExists($guestbookPost);

    delete(route('gaestebuch.destroy', ['gaestebuch' => $guestbookPost]))
        ->assertRedirect(route('gaestebuch.index'));

    $this->assertModelMissing($guestbookPost);
});

test('a guest can view the guestbook page', function () {
    // Ensure there are entries
    GuestbookPost::factory()
        ->count(5)
        ->create();

    get(route('gaestebuch.index'))
        ->assertOk()
        ->assertViewIs('guestbook_posts.index')
        ->assertViewHas('guestbook_posts')
        ->assertViewHas('title')
        ->assertViewHas('description')
        ->assertViewHas('query')
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
        ->assertViewIs('guestbook_posts.create')
        ->assertSeeText('Gästebuch: Neuer Eintrag');

    $entry = GuestbookPost::factory()->raw([
        'cheffe' => null,
        'category' => 'unsure',
        'spam_detection' => 'IP: 127.0.0.1, Browser: Symfony',
    ]);

    post(route('gaestebuch.store'), $entry)
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('gaestebuch.index'));

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

    post(route('gaestebuch.store'), $entry)
        ->assertSessionHasErrors(['name'])
        ->assertRedirect(route('gaestebuch.create'));
});

test('an entry must have a message', function () {
    $entry = GuestbookPost::factory()->raw([
        'message' => '',
        'cheffe' => null,
        'category' => 'unsure',
        'spam_detection' => 'IP: 127.0.0.1, Browser: Symfony',
    ]);

    post(route('gaestebuch.store'), $entry)
        ->assertSessionHasErrors(['message'])
        ->assertRedirect(route('gaestebuch.create'));
});
