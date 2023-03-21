<?php

declare(strict_types=1);

use App\Models\PublicationDate;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\put;

test('a guest cannot view all published cartoons', function () {
    get('/publication_dates')->assertRedirect('/login');
});

test('a user can view all published cartoons', function () {
    actingAs(User::factory()->create());
    get('/publication_dates')
        ->assertOk()
        ->assertViewIs('publication_dates.index')
        ->assertViewHas('title')
        ->assertViewHas('description')
        ->assertViewHas('dates')
        ->assertSeeText('31. März 2022')
        ->assertDontSeeText('3. Februar 2022')
        ->assertDontSeeText('25. November 2021');
});

test('a user can view all published cartoons on page 2', function () {
    actingAs(User::factory()->create());
    get('/publication_dates?page=2')
        ->assertOk()
        ->assertDontSeeText('31. März 2022')
        ->assertSeeText('3. Februar 2022')
        ->assertDontSeeText('25. November 2021');
});

test('a user can view all published cartoons on page 3', function () {
    actingAs(User::factory()->create());
    get('/publication_dates?page=3')
        ->assertOk()
        ->assertDontSeeText('31. März 2022')
        ->assertDontSeeText('3. Februar 2022')
        ->assertSeeText('25. November 2021');
});

test('a user cannot force a new cartoon for the current publication date', function () {
    actingAs(User::factory()->create());

    $current = PublicationDate::getCurrent();
    $latest = PublicationDate::latest('publish_on')->first();

    expect($latest->id)->not->toBe($current->id);

    get('/publication_dates/forceNewCartoon')->assertRedirect(
        '/publication_dates',
    );

    // Current should not have been changed ...
    expect($current)->toEqual(PublicationDate::getCurrent())
        // ... but the latest cartoon should have changed
        ->and($latest)->not->toEqual(
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

test('a user can edit and update a cartoon', closure: function () {
    actingAs(User::factory()->create());

    $publication_date = PublicationDate::where('publish_on', '2022-02-10')
        ->first();
    $rebus = $publication_date->cartoon->rebus;

    get(route('publication_dates.edit', $publication_date))
        ->assertOk()
        ->assertSeeText('Cartoon bearbeiten')
        ->assertSeeText('10. Februar 2022')
        ->assertSee($rebus)
        ->assertDontSee('New rebus text');

    put(
        route('publication_dates.update', [
            'publication_date' => $publication_date,
            'rebus' => 'New rebus text',
        ]),
    )->assertRedirect(route('publication_dates.index'));

    get(route('publication_dates.edit', $publication_date))
        ->assertOk()
        ->assertSeeText('Cartoon bearbeiten')
        ->assertSeeText('10. Februar 2022')
        ->assertDontSee($rebus)
        ->assertSee('New rebus text');
});
