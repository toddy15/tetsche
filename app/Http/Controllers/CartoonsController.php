<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\PublicationDate;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

class CartoonsController extends Controller
{
    /**
     * Display the current cartoon.
     */
    public function __invoke(): View
    {
        $date = PublicationDate::getCurrent();
        $carbonDate = new Carbon($date->publish_on);
        $carbonDate->locale('de');

        return view('cartoons.show', [
            'title' => 'Cartoon der Woche',
            'pagetitle' => 'Cartoon der Woche . . . vom '.
                $carbonDate->isoFormat('Do MMMM YYYY'),
            'description' => 'Tetsche - Cartoon der Woche',
            'date' => $date,
        ]);
    }
}
