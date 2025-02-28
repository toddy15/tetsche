<?php

declare(strict_types=1);

use App\Http\Controllers\CartoonsController;
use App\Models\User;

use function Pest\Laravel\actingAs;

test('check if current is last cartoon returns an ok response', function () {
    $this->get('cartoons/checkIfCurrentIsLastCartoon')
        ->assertRedirect(action(CartoonsController::class));
    // @TODO: perform additional assertions
});

test('a guest cannot force a new cartoon', function () {
    $this->get('publication_dates/forceNewCartoon')
        ->assertRedirect(route('login'));
});

test('a user can force a new cartoon', function () {
    actingAs(User::factory()->create());
    $this->get('publication_dates/forceNewCartoon')
        ->assertRedirect(route('publication_dates.index'));
    // @TODO: perform additional assertions
});
