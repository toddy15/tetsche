<?php

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

test('a guest cannot view all published cartoons', function () {
    get('/publication_dates')
        ->assertRedirect('/login');
});

test('a user can view all published cartoons', function () {
    actingAs(User::factory()->create());
    get('/publication_dates')
        ->assertOk()
        ->assertSeeText("31. März 2022")
        ->assertDontSeeText("3. Februar 2022")
        ->assertDontSeeText("18. November 2021");
});

test('a user can view all published cartoons on page 2', function () {
    actingAs(User::factory()->create());
    get('/publication_dates?page=2')
        ->assertOk()
        ->assertDontSeeText("31. März 2022")
        ->assertSeeText("3. Februar 2022")
        ->assertDontSeeText("18. November 2021");
});

test('a user can view all published cartoons on page 3', function () {
    actingAs(User::factory()->create());
    get('/publication_dates?page=3')
        ->assertOk()
        ->assertDontSeeText("31. März 2022")
        ->assertDontSeeText("3. Februar 2022")
        ->assertSeeText("18. November 2021");
});

test('a guest cannot force a new cartoon', function () {
    get('/publication_dates/forceNewCartoon')
        ->assertRedirect('/login');
});

test('a user cannot force a new cartoon for the current publication date', function () {
    actingAs(User::factory()->create());

    $current = PublicationDate::getCurrent();
    $latest = PublicationDate::latest('publish_on')->first();

    expect($latest->id)->not->toBe($current->id);

    get('/publication_dates/forceNewCartoon')
        ->assertRedirect('/publication_dates');

    // Current should not have been changed
    expect($current)->toEqual(PublicationDate::getCurrent());
    expect($latest)->not->toEqual(PublicationDate::latest('publish_on')->first());

    // @TODO: Check that another cartoon has been selected
});

test('a user can force a new cartoon for the next publication date', function () {
    actingAs(User::factory()->create());
    get('/publication_dates?page=3')
        ->assertOk()
        ->assertDontSeeText("31. März 2022")
        ->assertDontSeeText("3. Februar 2022")
        ->assertSeeText("18. November 2021");
})->skip();
