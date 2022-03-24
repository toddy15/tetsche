<?php

use App\Models\PublicationDate;

use function Pest\Laravel\get;

test('a guest can view the current cartoon', function () {
    // Ensure there is a PublicationDate
    PublicationDate::factory()->create(['publish_on' => '2022-03-11']);

    get('/cartoon')
        ->assertOk()
        ->assertSeeText('Cartoon der Woche . . . vom 11. März 2022')
        ->assertSeeText('Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.')
        ->assertSeeText('Auflösung nächste Woche');
});

test('a guest can view the next current cartoon', function () {
    // Ensure there are PublicationDates
    PublicationDate::factory()->create(['publish_on' => '2022-03-11']);
    PublicationDate::factory()->create(['publish_on' => '2022-03-17']);

    get('/cartoon')
        ->assertOk()
        ->assertSeeText('Cartoon der Woche . . . vom 17. März 2022')
        ->assertSeeText('Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.')
        ->assertSeeText('Auflösung nächste Woche');
});

test('a guest cannot view a future cartoon', function () {
    // Ensure there are PublicationDates
    PublicationDate::factory()->create(['publish_on' => '2022-03-11']);
    PublicationDate::factory()->create(['publish_on' => '2022-03-17']);
    PublicationDate::factory()->create(['publish_on' => '2022-03-24']);

    get('/cartoon')
        ->assertOk()
        ->assertSeeText('Cartoon der Woche . . . vom 17. März 2022')
        ->assertSeeText('Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.')
        ->assertSeeText('Auflösung nächste Woche');
});
