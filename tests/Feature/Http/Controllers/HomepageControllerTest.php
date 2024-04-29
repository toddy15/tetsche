<?php

declare(strict_types=1);

use function Pest\Laravel\get;

test('the homepage returns ok', function () {
    get(route('homepage'))
        ->assertOk();
    // @ TODO reenable after sonderseite has been deactivated
    // ->assertViewIs('pages.homepage')
    // ->assertViewHas('src')
    // ->assertViewHas('width')
    // ->assertViewHas('height');
});
