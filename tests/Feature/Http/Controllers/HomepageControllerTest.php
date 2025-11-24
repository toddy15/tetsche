<?php

declare(strict_types=1);

test('the homepage returns ok', function () {
    $this->get(route('homepage'))
        ->assertOk()
        ->assertViewIs('pages.sonderseite');
    /*
        ->assertViewHas('src')
        ->assertViewHas('width')
        ->assertViewHas('height');
    */
});
