<?php

declare(strict_types=1);

use App\Models\User;

use function Pest\Laravel\actingAs;

test('a guest cannot view the spam controller', function () {
    $this->get('spam')
        ->assertRedirect(route('login'));
});

test('a guest cannot relearn texts', function () {
    $this->get('spam/relearn')
        ->assertRedirect(route('login'));
});

test('a guest cannot view posts', function () {
    $this->get('spam/{category}')
        ->assertRedirect(route('login'));
});

test('a user can view the spam controller', function () {
    actingAs(User::factory()->create());
    $this->get('spam')
        ->assertOk()
        ->assertViewIs('admin.guestbook');
});

it('can relearn texts', function () {
    actingAs(User::factory()->create());
    $this->get('spam/relearn')
        ->assertRedirect('spam');
    // @TODO: perform additional assertions
});

test('show posts returns an ok response', function () {
    actingAs(User::factory()->create());
    $this->get('spam/manual_ham')
        ->assertOk()
        ->assertSeeText('Manuell als Ham gelernt')
        ->assertViewIs('guestbook_posts.index');
    // TODO: perform additional assertions
});
