<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PublicationDate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;

class ArchiveController extends Controller
{
    public function index(): View
    {
        $dates = PublicationDate::archived()->simplePaginate(8);

        return view('archive.index', [
            'title' => 'Archiv',
            'description' => 'Archiv – ältere Ausgaben',
            'dates' => $dates,
        ]);
    }

    public function show(PublicationDate $date): View|RedirectResponse
    {
        // Redirect to cartoon page for current date
        $current = PublicationDate::getCurrent();
        if ($date->is($current)) {
            return redirect()->action(CartoonsController::class);
        }

        abort_unless($date->isArchived(), 404);

        return view('archive.show', [
            'title' => 'Archiv',
            'pagetitle' => 'Cartoon der Woche . . . vom '.
                Carbon::parse($date->publish_on)
                    ->locale('de')
                    ->isoFormat('Do MMMM YYYY'),
            'description' => 'Archiv – ältere Ausgaben',
            'date' => $date,
        ]);
    }
}
