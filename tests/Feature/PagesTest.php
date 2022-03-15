<?php

namespace Tests\Feature;

use App\Cartoon;
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
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Tetsche-Website');

        $response = $this->get('/tetsche');
        $response->assertStatus(200);
        $response->assertSeeText('Tetsche veröffentlichte seinen ersten Cartoon im zarten Alter');

        $response = $this->get('/bücher');
        $response->assertStatus(200);
        $response->assertSeeText('Bücher');

        $response = $this->get('/impressum');
        $response->assertStatus(200);
        $response->assertSeeText('Impressum');

        $response = $this->get('/datenschutzerklärung');
        $response->assertStatus(200);
        $response->assertSeeText('Datenschutzerklärung');
    }

    /**
     * Test cartoon
     * @return void
     */
    public function test_cartoon_and_archive()
    {
        // Ensure there are Cartoons
        PublicationDate::factory()->count(30)->create();

        $response = $this->get('/cartoon');
        $response->assertStatus(200);
        // @TODO: figure out what's going on
//        $response->assertSeeText('Cartoon der Woche . . . vom');
        $response->assertSeeText('Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.');
        $response->assertSeeText('Auflösung nächste Woche');

        // @TODO: check archive with created dates above
        $response = $this->get('/archiv');
        $response->assertStatus(200);
        $response->assertSeeText('Archiv');
    }

    /**
     * Test gästebuch
     * @return void
     */
    public function test_guestbook()
    {
        // Ensure there are entries
        GuestbookPost::factory()->count(20)->create();

        $response = $this->get('/gästebuch');
        $response->assertStatus(200);
        $response->assertSeeText('Gästebuch');
        $response->assertSeeText('Name');
        $response->assertSeeText('Nachricht');

        // There has to be at least one cartoon for the rebus spamcheck.
        PublicationDate::factory()->create();

        $this->get('/gästebuch/neu')
            ->assertOk()
            ->assertSeeText('Gästebuch: Neuer Eintrag');

        $entry = GuestbookPost::factory()->raw();
        $this->assertDatabaseMissing('guestbook_posts', $entry);

        $this->post('/gästebuch', $entry)
            ->assertOk();

        $this->assertDatabaseHas('guestbook_posts', $entry);
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
