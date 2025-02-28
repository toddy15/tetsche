<?php

declare(strict_types=1);

use App\Models\GuestbookPost;
use App\Models\User;
use Carbon\Carbon;
use Tests\Seeders\CartoonSeeder;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertModelExists;
use function Pest\Laravel\assertModelMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\post;
use function Pest\Laravel\put;
use function Pest\Laravel\seed;
use function Pest\Laravel\withServerVariables;

uses()->beforeEach(function () {
    seed(CartoonSeeder::class);
    Carbon::setTestNow('2022-03-26 14:30:00');
});

test('a guest cannot edit an entry', function () {
    $guestbookPost = GuestbookPost::factory()->create();

    $this->get(route('gaestebuch.edit', ['gaestebuch' => $guestbookPost]))
        ->assertRedirect(route('login'));

    assertModelExists($guestbookPost);
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
    assertModelExists($guestbookPost);

    delete(route('gaestebuch.destroy', ['gaestebuch' => $guestbookPost]))
        ->assertRedirect(route('login'));

    assertModelExists($guestbookPost);
});

test('a user can edit an entry', function () {
    actingAs(User::factory()->create());

    $guestbookPost = GuestbookPost::factory()->create();

    $this->get(route('gaestebuch.edit', ['gaestebuch' => $guestbookPost]))
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
    assertModelExists($guestbookPost);

    delete(route('gaestebuch.destroy', ['gaestebuch' => $guestbookPost]))
        ->assertRedirect(route('gaestebuch.index'));

    assertModelMissing($guestbookPost);
});

test('a guest can view the guestbook page', function () {
    // Ensure there are entries
    GuestbookPost::factory()
        ->count(5)
        ->create();

    $this->get(route('gaestebuch.index'))
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

    $this->get(route('gaestebuch.create'))
        ->assertOk()
        ->assertViewIs('guestbook_posts.create')
        ->assertSeeText('Gästebuch: Neuer Eintrag');

    $entry = GuestbookPost::factory()->raw();

    post(route('gaestebuch.store'), $entry)
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('gaestebuch.index'));

    $name = $entry['name'];
    $message = $entry['message'];
    settype($name, 'string');
    settype($message, 'string');
    $this->get(route('gaestebuch.index'))
        ->assertSeeText($name)
        ->assertSeeText($message);
});

test('an entry must have a name', function () {
    $entry = GuestbookPost::factory()->raw([
        'name' => '',
    ]);

    post(route('gaestebuch.store'), $entry)
        ->assertSessionHasErrors(['name'])
        ->assertRedirect(route('gaestebuch.create'));
});

test('an entry must have a message', function () {
    $entry = GuestbookPost::factory()->raw([
        'message' => '',
    ]);

    post(route('gaestebuch.store'), $entry)
        ->assertSessionHasErrors(['message'])
        ->assertRedirect(route('gaestebuch.create'));
});

it('sets a timeout between posts', function () {
    $entry_a = GuestbookPost::factory()->raw();
    $entry_b = GuestbookPost::factory()->raw();

    Carbon::setTestNow('2023-09-29 10:00:00');
    post(route('gaestebuch.store'), $entry_a)
        ->assertSessionHasNoErrors()
        ->assertSessionMissing('error')
        ->assertRedirect(route('gaestebuch.index'));

    Carbon::setTestNow('2023-09-29 10:00:59');
    post(route('gaestebuch.store'), $entry_b)
        ->assertTooManyRequests();
});

it('creates a new entry after the timeout has expired', function () {
    $entry_a = GuestbookPost::factory()->raw();
    $entry_b = GuestbookPost::factory()->raw();

    Carbon::setTestNow('2023-09-29 10:00:00');
    post(route('gaestebuch.store'), $entry_a)
        ->assertSessionHasNoErrors()
        ->assertSessionMissing('error')
        ->assertRedirect(route('gaestebuch.index'));

    Carbon::setTestNow('2023-09-29 10:01:00');
    post(route('gaestebuch.store'), $entry_b)
        ->assertSessionHasNoErrors()
        ->assertSessionMissing('error')
        ->assertRedirect(route('gaestebuch.index'));
});

it('lets two different guests create new entries before the timeout has expired', function () {
    $entry_guest_a = GuestbookPost::factory()->raw();
    $entry_guest_b = GuestbookPost::factory()->raw();

    Carbon::setTestNow('2023-09-29 10:00:00');
    withServerVariables(['REMOTE_ADDR' => '127.0.0.1'])
        ->post(route('gaestebuch.store'), $entry_guest_a)
        ->assertSessionHasNoErrors()
        ->assertSessionMissing('error')
        ->assertRedirect(route('gaestebuch.index'));

    Carbon::setTestNow('2023-09-29 10:00:10');
    withServerVariables(['REMOTE_ADDR' => '127.0.0.2'])
        ->post(route('gaestebuch.store'), $entry_guest_b)
        ->assertSessionHasNoErrors()
        ->assertSessionMissing('error')
        ->assertRedirect(route('gaestebuch.index'));
});

it('ensures a maximum number of posts in a given interval', function () {
    // Insert 30 entries
    $time = Carbon::createFromTimeString('2023-10-11 10:00:00');
    for ($count = 1; $count <= 30; $count++) {
        Carbon::setTestNow($time);
        $entry = GuestbookPost::factory()->raw();
        post(route('gaestebuch.store'), $entry)
            ->assertSessionHasNoErrors()
            ->assertSessionMissing('error')
            ->assertRedirect(route('gaestebuch.index'));
        $time->addMinute();
    }

    // This entry should be rejected
    Carbon::setTestNow('2023-10-11 10:59:59');
    $entry = GuestbookPost::factory()->raw();
    post(route('gaestebuch.store'), $entry)
        ->assertTooManyRequests();

    // This entry should be allowed again
    Carbon::setTestNow('2023-10-11 11:00:00');
    $entry = GuestbookPost::factory()->raw();
    post(route('gaestebuch.store'), $entry)
        ->assertSessionHasNoErrors()
        ->assertSessionMissing('error')
        ->assertRedirect(route('gaestebuch.index'));
});
