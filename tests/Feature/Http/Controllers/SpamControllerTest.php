<?php

declare(strict_types=1);

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('a guest cannot view the spam controller', function () {
    get('spam')
        ->assertRedirect(route('login'));
});

test('a guest cannot relearn texts', function () {
    get('spam/relearn')
        ->assertRedirect(route('login'));
});

test('a guest cannot view posts', function () {
    get('spam/{category}')
        ->assertRedirect(route('login'));
});

test('a user can view the spam controller', function () {
    actingAs(User::factory()->create());
    get('spam')
        ->assertOk()
        ->assertViewIs('admin.guestbook');
});

it('can relearn texts', function () {
    actingAs(User::factory()->create());
    get('spam/relearn')
        ->assertRedirect('spam');
    // @TODO: perform additional assertions
});

test('show posts returns an ok response', function () {
    actingAs(User::factory()->create());
    get('spam/manual_ham')
        ->assertOk()
        ->assertSeeText('Manuell als Ham gelernt')
        ->assertViewIs('guestbook_posts.index');
    // TODO: perform additional assertions
});
