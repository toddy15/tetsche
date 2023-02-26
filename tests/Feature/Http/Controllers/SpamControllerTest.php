<?php

declare(strict_types=1);

use App\Http\Controllers\GuestbookPostsController;
use App\Models\PublicationDate;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
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

test('a guest cannot view the spam controller', function () {
    get('spam')
        ->assertRedirect(route('login'));
});

test('a guest cannot relearn texts', function () {
    get('spam/relearn')
        ->assertRedirect(route('login'));
});

test('a guest cannot view posts', function () {
    get('spam/{category}')
        ->assertRedirect(route('login'));
});

test('a user can view the spam controller', function () {
    actingAs(User::factory()->create());
    get('spam')
        ->assertOk()
        ->assertViewIs('admin.guestbook');
});

it('can relearn texts', function () {
    actingAs(User::factory()->create());
    get('spam/relearn')
        ->assertRedirect('spam');
    // @TODO: perform additional assertions
});

test('show posts returns an ok response', function () {
    actingAs(User::factory()->create());
    get('spam/{category}')
        ->assertRedirect(action([
            GuestbookPostsController::class, 'index',
        ]));
    // TODO: perform additional assertions
});
