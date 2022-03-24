<?php

use App\Models\PublicationDate;

use function Pest\Laravel\get;

beforeEach(function () {
    $publicationDates = [
        '2021-11-25',
        '2021-12-02',
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
        '2022-03-17',
        '2022-03-24',
    ];

    foreach ($publicationDates as $publicationDate) {
        PublicationDate::factory()->create(['publish_on' => $publicationDate]);
    }
});

test('a guest can view the archive', function () {
    // @TODO: check archive with created dates above
    get('/archiv')
        ->assertOk()
        ->assertSeeText('Archiv');
});
