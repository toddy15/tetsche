<?php

declare(strict_types=1);

use function Pest\Laravel\get;

test('the homepage returns ok', function () {
    get(route('homepage'))
        ->assertOk()
        ->assertSeeText('Tetsche-Website')
        ->assertViewIs('pages.homepage')
        ->assertViewHas('image_name');
});
