<?php

declare(strict_types=1);

use App\Services\Spamfilter;

it('can get a spamfilter instance', function () {
    $s = new Spamfilter;
    expect($s)->toBeInstanceOf(Spamfilter::class);
});

it('can parse a text into tokens', function () {
    $s = new Spamfilter;

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

it('recognizes certain IP addresses', function () {
    $s = new Spamfilter;

    // Test empty string
    $result = $s->isBlockedSubnet('');
    expect($result)->toBe(false);

    // Test home
    $result = $s->isBlockedSubnet('127.0.0.1');
    expect($result)->toBe(false);

    // Test 141.48
    $result = $s->isBlockedSubnet('141.49.15.56');
    expect($result)->toBe(false);
    $result = $s->isBlockedSubnet('141.48.15.56');
    expect($result)->toBe(true);
    $result = $s->isBlockedSubnet('141.48.241.15');
    expect($result)->toBe(true);

    // Test 217.240.29
    $result = $s->isBlockedSubnet('217.240.28.12');
    expect($result)->toBe(false);
    $result = $s->isBlockedSubnet('217.240.29.86');
    expect($result)->toBe(true);
    $result = $s->isBlockedSubnet('217.240.29.255');
    expect($result)->toBe(true);
});
