<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function homepage()
    {
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

    public function impressum()
    {
        return view('pages.impressum', [
            'title' => 'Impressum',
            'keywords' => 'Impressum, Kontakt, Anbieterkennzeichnung',
            'description' => 'Impressum, Kontaktadressen und Anbieterkennzeichnung der Tetsche-Website',
        ]);
    }
}
