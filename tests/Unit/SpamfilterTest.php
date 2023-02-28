<?php

declare(strict_types=1);

use App\Services\Spamfilter;

it('can get a spamfilter instance', function () {
    $s = new Spamfilter();
    expect($s)->toBeInstanceOf(Spamfilter::class);
});

it('can parse a text into tokens', function () {
    $s = new Spamfilter();

    $result = $s->parse('Those are words');
    expect($result)->toBe([
        'Those' => 1,
        'are' => 1,
        'words' => 1,
    ]);

    $result = $s->parse("Those\nare\nmore and more words");
    expect($result)->toBe([
        'Those' => 1,
        'are' => 1,
        'more' => 1,
        'and' => 1,
        'words' => 1,
    ]);
});
