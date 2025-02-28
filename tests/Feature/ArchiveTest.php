<?php

declare(strict_types=1);

use Carbon\Carbon;
use Tests\Seeders\CartoonSeeder;

use function Pest\Laravel\seed;

uses()->beforeEach(function () {
    seed(CartoonSeeder::class);
    Carbon::setTestNow('2022-03-26 14:30:00');
});

test('index returns an ok response', function () {
    $this->get(route('archiv.index'))
        ->assertOk()
        ->assertViewIs('archive.index')
        ->assertViewHas('title')
        ->assertViewHas('description')
        ->assertViewHas('dates');
});

test('a guest can view the first page of the archive', function () {
    $this->get('/archiv')
        ->assertOk()
        ->assertSeeText('Archiv')
        ->assertSeeText('3. Februar 2022')
        ->assertDontSeeText('9. Dezember 2021');
});

test('a guest can view the second page of the archive', function () {
    $this->get('/archiv?page=2')
        ->assertOk()
        ->assertSeeText('Archiv')
        ->assertDontSeeText('3. Februar 2022')
        ->assertSeeText('9. Dezember 2021');
});

test('a guest cannot view the third page of the archive', function () {
    $this->get('/archiv?page=3')
        ->assertOk()
        ->assertSeeText('Archiv')
        ->assertDontSeeText('3. Februar 2022')
        ->assertDontSeeText('9. Dezember 2021')
        ->assertDontSeeText('25. November 2021');
});

it('contains expected dates on the first page', function () {
    $this->get('/archiv')
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
    $this->get('/archiv/2022-03-03')
        ->assertOk()
        ->assertSeeText('Archiv')
        ->assertSeeText('Cartoon der Woche . . . vom 3. März 2022')
        ->assertSeeText(
            'Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.',
        )
        ->assertSeeText('Lösung anzeigen');
});

it('does show the oldest archived cartoon', function () {
    $this->get('/archiv/2021-12-02')
        ->assertOk()
        ->assertSeeText('Archiv')
        ->assertSeeText('Cartoon der Woche . . . vom 2. Dezember 2021')
        ->assertSeeText(
            'Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.',
        )
        ->assertSeeText('Lösung anzeigen');
});

it(
    'does not show older cartoons which are no longer in the archive',
    function () {
        $this->get('/archiv/2021-11-25')->assertNotFound();
    },
);

it('does not show future cartoons', function () {
    $this->get('/archiv/2022-03-31')->assertNotFound();
});

it('redirects to the current cartoon', function () {
    $this->get('/archiv/2022-03-24')->assertRedirect('/cartoon');
});

test('a guest cannot view a non-existing cartoon', function () {
    $this->get('/archiv/2022-03-08')->assertNotFound();
});
