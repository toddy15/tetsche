<?php

namespace App\Http\Controllers;

use App\Models\PublicationDate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PublicationDateController extends Controller
{
    public function index(): View
    {
        $dates = PublicationDate::orderBy('publish_on', 'desc')->simplePaginate(8);

        return view('publication_dates.index', [
            'title' => 'Übersicht',
            'keywords' => 'Tetsche, Kalauseite, Cartoon',
            'description' => 'Alle Ausgaben',
            'dates' => $dates,
        ]);
    }

    public function edit(PublicationDate $publication_date): View
    {
        return view('publication_dates.edit', [
            'date' => $publication_date,
        ]);
    }

    public function update(Request $request, PublicationDate $publicationDate)
    {
        $publicationDate->cartoon->rebus = $request->input('rebus');
        $publicationDate->cartoon->save();

        return redirect()->route('publication_dates.index');
    }
}
