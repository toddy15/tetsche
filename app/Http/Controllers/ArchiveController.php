<?php

namespace App\Http\Controllers;

use App\Models\PublicationDate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

class ArchiveController extends Controller
{
    public function index(): View
    {
        $date = CartoonsController::getDateOfCurrentCartoon();
        $last_archived = CartoonsController::getDateOfLastArchivedCartoon();
        $dates = PublicationDate::where('publish_on', '<', $date)
            ->where('publish_on', '>=', $last_archived)
            ->orderBy('publish_on', 'desc')->simplePaginate(8);

        return view('archive.index', [
            'title' => 'Archiv',
            'keywords' => 'Tetsche-Seite, Cartoon der Woche, Archiv',
            'description' => 'Archiv – ältere Ausgaben',
            'dates' => $dates,
        ]);
    }

    public function show(PublicationDate $date): View|RedirectResponse
    {
        // Redirect to cartoon page for current date
        $current = PublicationDate::getCurrent();
        if ($date->is($current)) {
            return redirect(action([CartoonsController::class, 'show']));
        }

        abort_unless($date->isArchived(), 404);

        return view('archive.show', [
            'title' => 'Archiv',
            'pagetitle' => 'Cartoon der Woche . . . vom '.Carbon::parse($date->publish_on)->locale('de')->isoFormat(
                'Do MMMM YYYY'
            ),
            'keywords' => 'Tetsche-Seite, Cartoon der Woche, Archiv',
            'description' => 'Archiv – ältere Ausgaben',
            'date' => $date,
        ]);
    }
}
