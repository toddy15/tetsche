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
            ->see('Tetsche-Website');
        $this->visit('tetsche')
            ->see('Tetsche wurde in Soltau, mitten in der Lüneburger Heide, geboren.');
        $this->visit('impressum')
            ->see('Angaben gemäß § 5 TMG');
        $this->visit('stern')
            ->see('Die Rebus-Abbildungen ergeben zusammen einen neuen Begriff.');
    }
}
