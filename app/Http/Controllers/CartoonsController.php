<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Cartoon;
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

        return view('cartoons.show', [
            'title' => 'Cartoon der Woche',
            'pagetitle' => 'Cartoon der Woche . . . vom '.
                Carbon::parse($date->publish_on)
                    ->locale('de')
                    ->isoFormat('Do MMMM YYYY'),
            'description' => 'Tetsche - Cartoon der Woche',
            'date' => $date,
        ]);
    }
}
