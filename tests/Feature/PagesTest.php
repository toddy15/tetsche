<?php

namespace Tests\Feature;

use App\Models\GuestbookPost;
use App\Models\PublicationDate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test gästebuch
     * @return void
     */
    public function test_guestbook()
    {
        // Ensure there are entries
        GuestbookPost::factory()->count(5)->create();

        $this->get(route('gaestebuch.index'))
            ->assertOk()
            ->assertSeeText('Gästebuch')
            ->assertSeeText('Name')
            ->assertSeeText('Nachricht');

        // There has to be at least one PublicationDate for the rebus spamcheck.
        PublicationDate::factory()->create();

        $this->get(route('gaestebuch.create'))
            ->assertOk()
            ->assertSeeText('Gästebuch: Neuer Eintrag');

        $entry = GuestbookPost::factory()->raw([
            'cheffe' => null,
            'category' => 'unsure',
            'spam_detection' => 'IP: 127.0.0.1, Browser: Symfony',
        ]);
        $this->assertDatabaseMissing('guestbook_posts', $entry);

        $this->post(route('gaestebuch.store'), $entry)
            ->assertRedirect();

        $this->assertDatabaseHas('guestbook_posts', $entry);

        $this->get(route('gaestebuch.index'))
            ->assertSeeText($entry['name'])
            ->assertSeeText($entry['message']);
    }
}
