<?php

use App\View\Components\Datetime;
use Carbon\Carbon;

it('returns a formatted date and time from the Datetime component', function () {
    $date = Carbon::parse('2024-04-30 17:13:45', 'UTC');
    $this->component(Datetime::class, ['date' => $date])
        ->assertSee('30. April 2024, 19:13');
});

it('returns a formatted date from the Datetime component', function () {
    $date = Carbon::parse('2024-04-30 17:13:45', 'UTC');
    $this->component(Datetime::class, ['date' => $date, 'format' => 'short'])
        ->assertDontSee('30. April 2024, 19:13')
        ->assertSee('30. April 2024')
        ->assertDontSee(':')
        ->assertDontSee('19:13');
});

it('returns a localized date from the Datetime component', function () {
    $date = Carbon::parse('2024-03-15 17:13:45', 'UTC');
    $this->component(Datetime::class, ['date' => $date])
        ->assertSee('15. März 2024, 18:13');
});

it('uses Europe/Berlin as timezone in the Datetime component', function () {
    $date = Carbon::parse('2024-03-15 17:13:45', 'Europe/Berlin');
    $this->component(Datetime::class, ['date' => $date])
        ->assertSee('15. März 2024, 17:13');
});
