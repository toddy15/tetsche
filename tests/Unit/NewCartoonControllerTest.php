<?php

declare(strict_types=1);

use App\Services\Cartoons;

it('returns the next thursday for a given date', function (string $date, string $thursday) {
    $c = new Cartoons;
    expect($c->getNextThursday($date))->toBe($thursday);
})->with([
    ['2023-03-15', '2023-03-16'],
    ['2023-03-16', '2023-03-16'],
    ['2023-03-17', '2023-03-23'],
    ['2023-03-18', '2023-03-23'],
    ['2023-03-19', '2023-03-23'],
    ['2023-03-20', '2023-03-23'],
    ['2023-03-21', '2023-03-23'],
    ['2023-03-22', '2023-03-23'],
    ['2023-03-23', '2023-03-23'],
    ['2023-03-24', '2023-03-30'],
]);

it('returns the last thursday for a given date', function (string $date, string $thursday) {
    $c = new Cartoons;
    expect($c->getLastThursday($date))->toBe($thursday);
})->with([
    ['2023-03-15', '2023-03-09'],
    ['2023-03-16', '2023-03-16'],
    ['2023-03-17', '2023-03-16'],
    ['2023-03-18', '2023-03-16'],
    ['2023-03-19', '2023-03-16'],
    ['2023-03-20', '2023-03-16'],
    ['2023-03-21', '2023-03-16'],
    ['2023-03-22', '2023-03-16'],
    ['2023-03-23', '2023-03-23'],
]);

it('returns the last thursday for special dates', function (string $date, string $thursday) {
    $c = new Cartoons;
    expect($c->getLastThursday($date))->toBe($thursday);
})->with([
    // easter
    ['2023-04-09', '2023-04-06'],
    // christmas
    ['2023-12-24', '2023-12-21'],
    // silvester
    ['2023-12-31', '2023-12-28'],
    // new year, first thursday in the new year
    ['2024-01-07', '2024-01-04'],
]);
