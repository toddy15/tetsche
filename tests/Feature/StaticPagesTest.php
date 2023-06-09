<?php

declare(strict_types=1);

use function Pest\Laravel\get;

it('has an about page', function () {
    get(route('tetsche'))
        ->assertOk()
        ->assertSeeText(
            'Tetsche veröffentlichte seinen ersten Cartoon im zarten Alter',
        );
});

it('has a buecher page', function () {
    get(route('buecher'))
        ->assertOk()
        ->assertSeeText('Bücher');
});

it('has an impressum page', function () {
    get(route('impressum'))
        ->assertOk()
        ->assertSeeText('Impressum');
});

it('has a datenschutz page', function () {
    get(route('datenschutz'))
        ->assertOk()
        ->assertSeeText('Datenschutzerklärung');
});
