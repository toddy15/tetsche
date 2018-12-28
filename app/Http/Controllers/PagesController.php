<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function homepage()
    {
        if (date("Y-m-d") <= "2019-01-01") {
            return view('pages.sonderseite', [
                'description' => 'Tetsche-Website',
            ]);
        }
        return view('pages.homepage', [
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

    public function impressum()
    {
        return view('pages.impressum', [
            'title' => 'Impressum',
            'keywords' => 'Impressum, Kontakt, Anbieterkennzeichnung',
            'description' => 'Impressum, Kontaktadressen und Anbieterkennzeichnung der Tetsche-Website',
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
