<?php

declare(strict_types=1);

it('has an about page', function () {
    $this->get(route('tetsche'))
        ->assertOk()
        ->assertSeeText(
            'Tetsche veröffentlichte seinen ersten Cartoon im zarten Alter',
        );
});

it('has a buecher page', function () {
    $this->get(route('buecher'))
        ->assertOk()
        ->assertSeeText('Bücher');
});

it('has an impressum page', function () {
    $this->get(route('impressum'))
        ->assertOk()
        ->assertSeeText('Impressum');
});

it('has a datenschutz page', function () {
    $this->get(route('datenschutz'))
        ->assertOk()
        ->assertSeeText('Datenschutzerklärung');
});
