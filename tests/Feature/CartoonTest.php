<?php

declare(strict_types=1);

use Carbon\Carbon;

use function Pest\Laravel\get;

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
    Carbon::setTestNow('2022-03-30 17:59:59');

    get('/cartoon')
        ->assertOk()
        ->assertSeeText('Cartoon der Woche . . . vom 24. März 2022')
        ->assertSeeText(
            'Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.',
        )
        ->assertSeeText('Auflösung nächste Woche');

    Carbon::setTestNow('2022-03-30 18:00:00');

    get('/cartoon')
        ->assertOk()
        ->assertSeeText('Cartoon der Woche . . . vom 31. März 2022')
        ->assertSeeText(
            'Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.',
        )
        ->assertSeeText('Auflösung nächste Woche');
});
