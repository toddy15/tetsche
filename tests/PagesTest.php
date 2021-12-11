<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class PagesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicPages()
    {
        $this->visit('/')
            ->seeInElement('h1', 'Tetsche-Website');
        $this->visit('tetsche')
            ->see('Tetsche veröffentlichte seinen ersten Cartoon im zarten Alter');
        $this->visit('cartoon')
            ->seeInElement('h1', 'Cartoon der Woche . . . vom')
            ->see('Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.')
            ->see('Auflösung nächste Woche');
        $this->visit('archiv')
            ->seeInElement('h1', 'Archiv');
        $this->visit('gästebuch')
            ->seeInElement('h1', 'Gästebuch')
            ->see('Name')
            ->see('Nachricht');
        $this->visit('impressum')
            ->seeInElement('h1', 'Impressum')
            ->see('Angaben gemäß § 5 TMG');
    }

    /**
     * Test guestbook functionality.
     *
     * @return void
     */
    public function testCreateANewGuestbookEntry()
    {
        // @TODO: Laravel 5.3 provides this method.
//        $this->visit('gästebuch')
//            ->click('Neuer Eintrag')
//            ->seeRouteIs('g%C3%A4stebuch/neu');
        $faker = Faker\Factory::create();
        $name = "Herr Hallmackenreuther";
        $message = "Mein Name ist Lohse. Ich kaufe hier ein.";
        // Ensure that the text is not there yet.
        $this->visit('gästebuch')
            ->dontSee($name)
            ->dontSee($message);
        $this->dontSeeInDatabase('guestbook_posts', [
            'name' => $name,
            'message' => $message,
        ]);
        // Create the new entry
        $this->visit('gästebuch/neu')
            ->seeInElement('h1', 'Gästebuch: Neuer Eintrag')
            ->type($name, 'name')
            ->type($message, 'message')
            ->press('Speichern')
            ->see('Der Eintrag wurde gespeichert.');
        // Ensure that the text is there.
        $this->visit('gästebuch')
            ->see($name)
            ->see($message);
        $this->seeInDatabase('guestbook_posts', [
            'name' => $name,
            'message' => $message,
        ]);
    }
}
