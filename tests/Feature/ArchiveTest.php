<?php

use App\Models\PublicationDate;

use function Pest\Laravel\get;
use function Spatie\PestPluginTestTime\testTime;

beforeEach(function () {
    $publicationDates = [
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

    foreach ($publicationDates as $publicationDate) {
        PublicationDate::factory()->create(['publish_on' => $publicationDate]);
    }

    testTime()->freeze('2022-03-26 14:30:00');
});

test('a guest can view the first page of the archive', function () {
    get('/archiv')
        ->assertOk()
        ->assertSeeText('Archiv')
        ->assertSeeText('3. Februar 2022')
        ->assertDontSeeText('9. Dezember 2021');
});

test('a guest can view the second page of the archive', function () {
    get('/archiv?page=2')
        ->assertOk()
        ->assertSeeText('Archiv')
        ->assertDontSeeText('3. Februar 2022')
        ->assertSeeText('9. Dezember 2021');
});

test('a guest cannot view the third page of the archive', function () {
    get('/archiv?page=3')
        ->assertOk()
        ->assertSeeText('Archiv')
        ->assertDontSeeText('3. Februar 2022')
        ->assertDontSeeText('9. Dezember 2021')
        ->assertDontSeeText('18. November 2021');
});

it('contains expected dates on the first page', function () {
    get('/archiv')
        ->assertOk()
        ->assertSeeText('Archiv')
        ->assertSeeText('27. Januar 2022')
        ->assertSeeText('3. Februar 2022')
        ->assertSeeText('10. Februar 2022')
        ->assertSeeText('17. Februar 2022')
        ->assertSeeText('24. Februar 2022')
        ->assertSeeText('3. März 2022')
        ->assertSeeText('10. März 2022')
        ->assertSeeText('17. März 2022');
});

test('a guest can view an archived cartoon', function () {
    get('/archiv/2022-03-03')
        ->assertOk()
        ->assertSeeText('Archiv')
        ->assertSeeText('Cartoon der Woche . . . vom 3. März 2022')
        ->assertSeeText('Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.')
        ->assertSeeText('Lösung anzeigen');
});

it('does show the oldest archived cartoon', function () {
    get('/archiv/2021-12-02')
        ->assertOk()
        ->assertSeeText('Archiv')
        ->assertSeeText('Cartoon der Woche . . . vom 2. Dezember 2021')
        ->assertSeeText('Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.')
        ->assertSeeText('Lösung anzeigen');
});

it('does not show older cartoons which are no longer in the archive', function () {
    get('/archiv/2021-11-25')
        ->assertNotFound();
});

it('does not show future cartoons', function () {
    get('/archiv/2022-03-31')
        ->assertNotFound();
});

it('redirects to the current cartoon', function () {
    get('/archiv/2022-03-24')
        ->assertRedirect("/cartoon");
});

test('a guest cannot view a non-existing cartoon', function () {
    get('/archiv/2022-03-08')
        ->assertNotFound();
});
