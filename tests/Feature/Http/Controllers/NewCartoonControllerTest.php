<?php

declare(strict_types=1);

use App\Http\Controllers\CartoonsController;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

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
