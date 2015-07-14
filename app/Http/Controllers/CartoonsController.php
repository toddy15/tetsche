<?php

namespace App\Http\Controllers;

use App\Cartoon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CartoonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $cartoons = Cartoon::orderBy('publish_on', 'desc')->simplePaginate(8);
        return view('cartoons.index', [
            'title' => 'Übersicht',
            'keywords' => 'Tetsche im »stern«, Kalauseite, Cartoon',
            'description' => 'Alle Ausgaben',
            'cartoons' => $cartoons,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Find the date of the newest cartoon
        $newest_cartoon = Cartoon::orderBy('publish_on', 'desc')->first();
        $newest_cartoon_date = $newest_cartoon->publish_on;
        // Calculate the next Thursday, starting three days from the newest date
        $offset = 3;
        list($year, $month, $day) = explode('-', $newest_cartoon_date);
        while (date("w", mktime(0, 0, 0, $month, $day + $offset, $year)) != 4) {
            $offset++;
        }
        // Construct and explode the date again to cope with
        // overflows (e.g. 2015-03-35) and get a valid date
        $next_thursday = date("Y-n-j", mktime(0, 0, 0, $month, $day + $offset, $year));
        list($year, $month, $day) = explode('-', $next_thursday);
        return view('cartoons.create', [
            'title' => 'Neuer Cartoon',
            'year' => $year,
            'month' => $month,
            'day' => $day,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display an archived cartoon.
     *
     * @return Response
     */
    public function show($date)
    {
        $current_date = $this->getDateOfCurrentCartoon();
        // Make sure that no unpublished cartoons get shown
        if ($date > $current_date) {
            abort(404);
        }
        // Redirect to stern page for current date
        if ($date == $current_date) {
            return redirect(action('CartoonsController@showCurrent'));
        }
        // Search cartoon for the given date
        $cartoon = Cartoon::where('publish_on', '=', $date)->first();
        // Show 404 if the cartoon is not found
        if (!$cartoon) {
            abort(404);
        }
        $cartoon->showRebusSolution = true;
        return view('cartoons.show', [
            'title' => 'Archiv',
            'keywords' => 'Tetsche im »stern«, Kalauseite, Cartoon, Kalau-Archiv, Archiv',
            'description' => 'Archiv - ältere Ausgaben',
            'cartoon' => $cartoon,
        ]);
    }

    /**
     * Display the current cartoon.
     *
     * @return Response
     */
    public function showCurrent()
    {
        $date = $this->getDateOfCurrentCartoon();
        $cartoon = Cartoon::where('publish_on', '=', $date)->first();
        $cartoon->showRebusSolution = false;
        return view('cartoons.show', [
            'title' => 'Stern',
            'keywords' => 'Tetsche im »stern«, Kalauseite, Cartoon',
            'description' => 'Tetsche im »stern« - jede Woche neu!',
            'cartoon' => $cartoon,
        ]);
    }

    /**
     * Display a listing of the archive.
     *
     * @return Response
     */
    public function showArchive()
    {
        $date = $this->getDateOfCurrentCartoon();
        $cartoons = Cartoon::where('publish_on', '<', $date)
            ->orderBy('publish_on', 'desc')->simplePaginate(8);
        return view('cartoons.archive', [
            'title' => 'Archiv',
            'keywords' => 'Tetsche im »stern«, Kalauseite, Cartoon, Kalau-Archiv, Archiv',
            'description' => 'Archiv - ältere Ausgaben',
            'cartoons' => $cartoons,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    ///////////////////////////////////
    // Helper methods
    ///////////////////////////////////

    /**
     * Helper method to determine the current cartoon.
     */
    private function getDateOfCurrentCartoon() {
        // Add 6 hours to the current time, so that the
        // cartoon is published at 18:00 one day before.
        $date = date('Y-m-d', time() + 6 * 60 * 60);
        return Cartoon::where('publish_on', '<=', $date)
            ->orderBy('publish_on', 'desc')
            ->value('publish_on');
    }
}
