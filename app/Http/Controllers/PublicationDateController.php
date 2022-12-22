<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PublicationDate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PublicationDateController extends Controller
{
    public function index(): View
    {
        $dates = PublicationDate::latest('publish_on')->simplePaginate(8);

        return view('publication_dates.index', [
            'title' => 'Übersicht',
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

    public function update(
        Request $request,
        PublicationDate $publicationDate,
    ): RedirectResponse {
        $publicationDate->cartoon->rebus = $request->input('rebus');
        $publicationDate->cartoon->save();

        return to_route('publication_dates.index');
    }
}
