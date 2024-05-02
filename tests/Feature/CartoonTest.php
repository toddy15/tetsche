<?php

declare(strict_types=1);

use Carbon\Carbon;
use Tests\Seeders\CartoonSeeder;

use function Pest\Laravel\get;
use function Pest\Laravel\seed;

uses()->beforeEach(function () {
    seed(CartoonSeeder::class);
    Carbon::setTestNow('2022-03-26 14:30:00');
});

test('a guest can view the current cartoon', function () {
    get('/cartoon')
        ->assertOk()
        ->assertViewIs('cartoons.show')
        ->assertViewHas('title')
        ->assertViewHas('pagetitle')
        ->assertViewHas('description')
        ->assertViewHas('date')
        ->assertSeeText('Cartoon der Woche . . . vom 24. März 2022')
        ->assertSeeText(
            'Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.',
        )
        ->assertSeeText('Auflösung nächste Woche');
});

test('a guest can view the next current cartoon', function () {
    Carbon::setTestNow('2022-04-01 14:30:00');

    get('/cartoon')
        ->assertOk()
        ->assertSeeText('Cartoon der Woche . . . vom 31. März 2022')
        ->assertSeeText(
            'Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.',
        )
        ->assertSeeText('Auflösung nächste Woche');
});

test('a guest can view the next cartoon at the correct time', function () {
    // The given time is UTC -> convert to 17:59:59 CEST
    Carbon::setTestNow('2022-03-30 15:59:59');

    get('/cartoon')
        ->assertOk()
        ->assertSeeText('Cartoon der Woche . . . vom 24. März 2022')
        ->assertSeeText(
            'Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.',
        )
        ->assertSeeText('Auflösung nächste Woche');

    // The given time is UTC -> convert to 18:00:00 CEST
    Carbon::setTestNow('2022-03-30 16:00:00');

    get('/cartoon')
        ->assertOk()
        ->assertSeeText('Cartoon der Woche . . . vom 31. März 2022')
        ->assertSeeText(
            'Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.',
        )
        ->assertSeeText('Auflösung nächste Woche');
});
