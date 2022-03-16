<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    public function homepage()
    {
        return view('pages.sonderseite', [
            'description' => 'Tetsche-Website',
        ]);
    }

    public function tetsche()
    {
        return view('pages.tetsche', [
            'title' => 'Über Tetsche',
            'keywords' => 'Informationen, Information',
            'description' => 'Informationen über Tetsche',
        ]);
    }

    public function buecher()
    {
        return view('pages.buecher', [
            'title' => 'Bücher',
            'keywords' => 'Buch, Bücher, Buchveröffentlichung',
            'description' => 'Bücher von Tetsche',
        ]);
    }

    public function datenschutzerklaerung()
    {
        return view('pages.datenschutzerklaerung', [
            'title' => 'Datenschutzerklärung',
            'keywords' => 'Datenschutzerklärung, Datenschutz, DSGVO',
            'description' => 'Datenschutzerklärung der Tetsche-Website',
        ]);
    }
}
