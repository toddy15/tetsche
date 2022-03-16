<?php

namespace Tests\Feature;

use App\GuestbookPost;
use App\PublicationDate;
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
        $this->get('/')
            ->assertOk()
            ->assertSeeText('Tetsche-Website');

        $this->get('/tetsche')
            ->assertOk()
            ->assertSeeText('Tetsche veröffentlichte seinen ersten Cartoon im zarten Alter');

        $this->get('/bücher')
            ->assertOk()
            ->assertSeeText('Bücher');

        $this->get(route('impressum'))
            ->assertOk()
            ->assertSeeText('Impressum');

        $this->get('/datenschutzerklärung')
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

        $this->get(route('gästebuch.index'))
            ->assertOk()
            ->assertSeeText('Gästebuch')
            ->assertSeeText('Name')
            ->assertSeeText('Nachricht');

        // There has to be at least one PublicationDate for the rebus spamcheck.
        PublicationDate::factory()->create();

        $this->get(route('gästebuch.create'))
            ->assertOk()
            ->assertSeeText('Gästebuch: Neuer Eintrag');

        $entry = GuestbookPost::factory()->raw([
            'cheffe' => null,
            'category' => 'unsure',
            'spam_detection' => 'IP: 127.0.0.1, Browser: Symfony',
        ]);
        $this->assertDatabaseMissing('guestbook_posts', $entry);

        $this->post(route('gästebuch.store'), $entry)
            ->assertRedirect();

        $this->assertDatabaseHas('guestbook_posts', $entry);

        $this->get(route('gästebuch.index'))
            ->assertSeeText($entry['name'])
            ->assertSeeText($entry['message']);
    }
}

/* * @return void
 * public function testCreateANewGuestbookEntry()
 * {
 * // @TODO: Laravel 5.3 provides this method.
 * //        $this->visit('gästebuch')
 * //            ->click('Neuer Eintrag')
 * //            ->seeRouteIs('g%C3%A4stebuch/neu');
 * $faker = Faker\Factory::create();
 * $name = "Herr Hallmackenreuther";
 * $message = "Mein Name ist Lohse. Ich kaufe hier ein.";
 * // Ensure that the text is not there yet.
 * $this->visit('gästebuch')
 * ->dontSee($name)
 * ->dontSee($message);
 * $this->dontSeeInDatabase('guestbook_posts', [
 * 'name' => $name,
 * 'message' => $message,
 * ]);
 * // Create the new entry
 * $this->visit('gästebuch/neu')
 * ->seeInElement('h1', 'Gästebuch: Neuer Eintrag')
 * ->type($name, 'name')
 * ->type($message, 'message')
 * ->press('Speichern')
 * ->see('Der Eintrag wurde gespeichert.');
 * // Ensure that the text is there.
 * $this->visit('gästebuch')
 * ->see($name)
 * ->see($message);
 * $this->seeInDatabase('guestbook_posts', [
 * 'name' => $name,
 * 'message' => $message,
 * ]);
 * }
 * }
 */
