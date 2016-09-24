<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PagesTest extends TestCase
{
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
            ->see('Tetsche wurde in Soltau, mitten in der Lüneburger Heide, geboren.');
        $this->visit('stern')
            ->seeInElement('h1', 'Tetsche im »stern« vom')
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
}
