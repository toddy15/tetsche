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

        return view('cartoons.archive', [
            'title' => 'Archiv',
            'keywords' => 'Tetsche-Seite, Cartoon der Woche, Archiv',
            'description' => 'Archiv – ältere Ausgaben',
            'dates' => $dates,
        ]);
    }

    public function show(PublicationDate $publicationDate): View|RedirectResponse
    {
        $current_date = CartoonsController::getDateOfCurrentCartoon();
        $last_archived = CartoonsController::getDateOfLastArchivedCartoon();
        // Make sure that no unpublished cartoons get shown
        if ($publicationDate->publish_on > $current_date) {
            abort(404);
        }
        // Redirect to cartoon page for current date
        if ($publicationDate->publish_on == $current_date) {
            return redirect(action([CartoonsController::class, 'showCurrent']));
        }
        // Make sure no older cartoons than allowed are shown
        if ($publicationDate->publish_on < $last_archived) {
            abort(404);
        }
        // Search cartoon for the given date
        $cartoon = $publicationDate->cartoon()->first();
        $cartoon->showRebusSolution = true;

        return view('cartoons.show', [
            'title' => 'Archiv',
            'pagetitle' => 'Cartoon der Woche . . . vom '.Carbon::parse($publicationDate->publish_on)->locale('de')->isoFormat('Do MMMM YYYY'),
            'keywords' => 'Tetsche, Kalauseite, Cartoon, Kalau-Archiv, Archiv',
            'description' => 'Archiv - ältere Ausgaben',
            'cartoon' => $cartoon,
        ]);
    }
}
