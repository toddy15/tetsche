<?php

declare(strict_types=1);

use App\Models\Exhibition;
use App\Models\User;
use Carbon\Carbon;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

it('shows the overview of exhibitions when there are no exhibitions', function () {
    get(route('ausstellungen.index'))
        ->assertOk();
});

it('does not show expired exhibitions', function () {
    Exhibition::factory()->create([
        'title' => 'Expired exhibition',
        'show_until' => Carbon::yesterday()],
    );
    get(route('ausstellungen.index'))
        ->assertOk()
        ->assertSeeText('Aktuell findet keine Ausstellung statt.')
        ->assertDontSeeText('Expired exhibition');
});

it('shows active exhibitions', function () {
    Exhibition::factory()->create([
        'title' => 'Active exhibition',
        'show_until' => Carbon::tomorrow()],
    );
    get(route('ausstellungen.index'))
        ->assertOk()
        ->assertDontSeeText('Aktuell findet keine Ausstellung statt.')
        ->assertSeeText('Active exhibition');
});

it('shows multiple active exhibitions in correct order', function () {
    Exhibition::factory()->create([
        'title' => 'Active exhibition 1',
        'show_until' => Carbon::tomorrow()->addWeek()],
    );
    Exhibition::factory()->create([
        'title' => 'Active exhibition 2',
        'show_until' => Carbon::tomorrow()],
    );
    get(route('ausstellungen.index'))
        ->assertOk()
        ->assertDontSeeText('Aktuell findet keine Ausstellung statt.')
        ->assertSeeTextInOrder(['Active exhibition 2', 'Active exhibition 1']);
});

test('a guest cannot create an exhibition', function () {
    get(route('ausstellungen.create'))
        ->assertRedirect(route('login'));

    $exhibition = Exhibition::factory()->make();
    post(route('ausstellungen.store', $exhibition->toArray()))
        ->assertRedirect(route('login'));
});

test('a guest cannot update an exhibition', function () {
    $exhibition = Exhibition::factory()->create();
    get(route('ausstellungen.edit', $exhibition))
        ->assertRedirect(route('login'));

    put(route('ausstellungen.update', $exhibition), $exhibition->toArray())
        ->assertRedirect(route('login'));
});

test('a guest cannot destroy an exhibition', function () {
    $exhibition = Exhibition::factory()->create();
    delete(route('ausstellungen.destroy', $exhibition))
        ->assertRedirect(route('login'));
});

test('a user can create an exhibition', function () {
    actingAs(User::factory()->create());

    get(route('ausstellungen.create'))
        ->assertOk();

    $exhibition = Exhibition::factory()->make();
    assertDatabaseMissing('exhibitions', $exhibition->toArray());

    post(route('ausstellungen.store', $exhibition->toArray()))
        ->assertRedirect(route('ausstellungen.index'));

    assertDatabaseHas('exhibitions', $exhibition->toArray());
});

test('a user can update an exhibition', function () {
    actingAs(User::factory()->create());

    $exhibition = Exhibition::factory()->create();
    assertDatabaseHas('exhibitions', ['title' => $exhibition->title]);

    get(route('ausstellungen.edit', $exhibition))
        ->assertOk();

    $exhibition->title = 'New title';
    put(route('ausstellungen.update', $exhibition), $exhibition->toArray())
        ->assertRedirect(route('ausstellungen.index'));

    assertDatabaseHas('exhibitions', ['title' => $exhibition->title]);
});

test('a user can delete an exhibition', function () {
    actingAs(User::factory()->create());

    $exhibition = Exhibition::factory()->create();
    assertDatabaseHas('exhibitions', ['title' => $exhibition->title]);
    delete(route('ausstellungen.destroy', $exhibition))
        ->assertRedirect(route('ausstellungen.index'));
    assertDatabaseMissing('exhibitions', ['title' => $exhibition->title]);
});
