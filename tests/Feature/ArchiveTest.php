<?php

use App\Models\PublicationDate;

use function Pest\Laravel\get;

test('a guest can view the archive', function () {
    // Ensure there are some PublicationDates
    PublicationDate::factory()->count(20)->create();

    // @TODO: check archive with created dates above
    get('/archiv')
        ->assertOk()
        ->assertSeeText('Archiv');
});
