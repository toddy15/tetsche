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

    public function show(PublicationDate $date): View|RedirectResponse
    {
        $current = PublicationDate::getCurrent();
        // Redirect to cartoon page for current date
        if ($date->is($current)) {
            return redirect(action([CartoonsController::class, 'showCurrent']));
        }

        $current_date = $current->publish_on;
        $last_archived = CartoonsController::getDateOfLastArchivedCartoon();
        // Make sure that no unpublished cartoons get shown
        if ($date->publish_on > $current_date) {
            abort(404);
        }
        // Make sure no older cartoons than allowed are shown
        if ($date->publish_on < $last_archived) {
            abort(404);
        }
        // Get cartoon for the given date
        $cartoon = $date->cartoon;
        $cartoon->showRebusSolution = true;

        return view('cartoons.show', [
            'title' => 'Archiv',
            'pagetitle' => 'Cartoon der Woche . . . vom '.Carbon::parse($date->publish_on)->locale('de')->isoFormat('Do MMMM YYYY'),
            'keywords' => 'Tetsche, Kalauseite, Cartoon, Kalau-Archiv, Archiv',
            'description' => 'Archiv - ältere Ausgaben',
            'cartoon' => $cartoon,
        ]);
    }
}
