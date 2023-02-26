<?php

declare(strict_types=1);

use App\Models\PublicationDate;
use function Pest\Laravel\get;
use function Spatie\PestPluginTestTime\testTime;

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

    testTime()->freeze('2022-03-26 14:30:00');
});

test('a guest can view the current cartoon', function () {
    get('/cartoon')
        ->assertOk()
        ->assertSeeText('Cartoon der Woche . . . vom 24. März 2022')
        ->assertSeeText(
            'Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.',
        )
        ->assertSeeText('Auflösung nächste Woche');
});

test('a guest can view the next current cartoon', function () {
    testTime()->freeze('2022-04-01 14:30:00');

    get('/cartoon')
        ->assertOk()
        ->assertSeeText('Cartoon der Woche . . . vom 31. März 2022')
        ->assertSeeText(
            'Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.',
        )
        ->assertSeeText('Auflösung nächste Woche');
});

test('a guest can view the next cartoon at the correct time', function () {
    testTime()->freeze('2022-03-30 17:59:59');

    get('/cartoon')
        ->assertOk()
        ->assertSeeText('Cartoon der Woche . . . vom 24. März 2022')
        ->assertSeeText(
            'Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.',
        )
        ->assertSeeText('Auflösung nächste Woche');

    testTime()->freeze('2022-03-30 18:00:00');

    get('/cartoon')
        ->assertOk()
        ->assertSeeText('Cartoon der Woche . . . vom 31. März 2022')
        ->assertSeeText(
            'Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.',
        )
        ->assertSeeText('Auflösung nächste Woche');
});
