<?php

declare(strict_types=1);

use function Pest\Laravel\get;

test('the homepage returns ok', function () {
    get(route('homepage'))
        ->assertOk()
        ->assertViewIs('pages.homepage')
        ->assertViewHas('src')
        ->assertViewHas('width')
        ->assertViewHas('height');
});
