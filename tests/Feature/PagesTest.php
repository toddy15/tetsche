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
     * Test static pages.
     *
     * @return void
     */
    public function test_static_pages()
    {
        $this->get(route('homepage'))
            ->assertOk()
            ->assertSeeText('Tetsche-Website');

        $this->get(route('tetsche'))
            ->assertOk()
            ->assertSeeText('Tetsche veröffentlichte seinen ersten Cartoon im zarten Alter');

        $this->get(route('buecher'))
            ->assertOk()
            ->assertSeeText('Bücher');

        $this->get(route('impressum'))
            ->assertOk()
            ->assertSeeText('Impressum');

        $this->get(route('datenschutz'))
            ->assertOk()
            ->assertSeeText('Datenschutzerklärung');
    }

    /**
     * Test cartoon
     * @return void
     */
    public function test_cartoon_and_archive()
    {
        // Ensure there are Cartoons
        PublicationDate::factory()->count(30)->create();

        $this->get('/cartoon')
            ->assertOk()
            ->assertSeeText('Cartoon der Woche . . . vom')
            ->assertSeeText('Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.')
            ->assertSeeText('Auflösung nächste Woche');

        // @TODO: check archive with created dates above
        $this->get('/archiv')
            ->assertOk()
            ->assertSeeText('Archiv');
    }

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
