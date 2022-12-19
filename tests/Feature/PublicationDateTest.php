<?php

declare(strict_types=1);

use App\Models\PublicationDate;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
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

test('a guest cannot view all published cartoons', function () {
    get('/publication_dates')->assertRedirect('/login');
});

test('a user can view all published cartoons', function () {
    actingAs(User::factory()->create());
    get('/publication_dates')
        ->assertOk()
        ->assertSeeText('31. März 2022')
        ->assertDontSeeText('3. Februar 2022')
        ->assertDontSeeText('18. November 2021');
});

test('a user can view all published cartoons on page 2', function () {
    actingAs(User::factory()->create());
    get('/publication_dates?page=2')
        ->assertOk()
        ->assertDontSeeText('31. März 2022')
        ->assertSeeText('3. Februar 2022')
        ->assertDontSeeText('18. November 2021');
});

test('a user can view all published cartoons on page 3', function () {
    actingAs(User::factory()->create());
    get('/publication_dates?page=3')
        ->assertOk()
        ->assertDontSeeText('31. März 2022')
        ->assertDontSeeText('3. Februar 2022')
        ->assertSeeText('18. November 2021');
});

test('a guest cannot force a new cartoon', function () {
    get('/publication_dates/forceNewCartoon')->assertRedirect('/login');
});

test(
    'a user cannot force a new cartoon for the current publication date',
    function () {
        actingAs(User::factory()->create());

        $current = PublicationDate::getCurrent();
        $latest = PublicationDate::latest('publish_on')->first();

        expect($latest->id)->not->toBe($current->id);

        get('/publication_dates/forceNewCartoon')->assertRedirect(
            '/publication_dates',
        );

        // Current should not have been changed ...
        expect($current)->toEqual(PublicationDate::getCurrent());
        // ... but the latest cartoon should have changed
        expect($latest)->not->toEqual(
            PublicationDate::latest('publish_on')->first(),
        );
    },
);

test('a guest cannot edit or update a cartoon', function () {
    get('/publication_dates/13/edit')->assertRedirect(route('login'));
    put('/publication_dates/13', ['rebus' => 'New rebus text'])->assertRedirect(
        route('login'),
    );
});

test(
    'a user can edit and update a cartoon',
    closure: function () {
        actingAs(User::factory()->create());

        $id = 13;
        $rebus = PublicationDate::find($id)->cartoon->rebus;

        get(route('publication_dates.edit', $id))
            ->assertOk()
            ->assertSeeText('Cartoon bearbeiten')
            ->assertSeeText('10. Februar 2022')
            ->assertSee($rebus)
            ->assertDontSee('New rebus text');

        put(
            route('publication_dates.update', [
                'publication_date' => $id,
                'rebus' => 'New rebus text',
            ]),
        )->assertRedirect(route('publication_dates.index'));

        get(route('publication_dates.edit', $id))
            ->assertOk()
            ->assertSeeText('Cartoon bearbeiten')
            ->assertSeeText('10. Februar 2022')
            ->assertDontSee($rebus)
            ->assertSee('New rebus text');
    },
);
