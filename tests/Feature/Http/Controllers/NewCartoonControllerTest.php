<?php

declare(strict_types=1);

use App\Http\Controllers\CartoonsController;
use App\Models\Cartoon;
use App\Models\PublicationDate;
use App\Models\User;
use Carbon\Carbon;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $dates = [
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

    Carbon::setTestNow('2022-03-26 14:30:00');
});

test('check if current is last cartoon returns an ok response', function () {
    get('cartoons/checkIfCurrentIsLastCartoon')
        ->assertRedirect(action(CartoonsController::class));
    // @TODO: perform additional assertions
});

test('a guest cannot force a new cartoon', function () {
    get('publication_dates/forceNewCartoon')
        ->assertRedirect(route('login'));
});

test('a user can force a new cartoon', function () {
    actingAs(User::factory()->create());
    get('publication_dates/forceNewCartoon')
        ->assertRedirect(route('publication_dates.index'));
    // @TODO: perform additional assertions
});
