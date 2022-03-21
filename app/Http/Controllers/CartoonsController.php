<?php

namespace App\Http\Controllers;

use App\Models\Cartoon;
use App\Models\PublicationDate;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartoonsController extends Controller
{
    public function index(): View
    {
        $publication_dates = PublicationDate::orderBy('publish_on', 'desc')->simplePaginate(8);

        return view('cartoons.index', [
            'title' => 'Übersicht',
            'keywords' => 'Tetsche, Kalauseite, Cartoon',
            'description' => 'Alle Ausgaben',
            'publication_dates' => $publication_dates,
        ]);
    }

    /**
     * Display an archived cartoon.
     */
    public function show($date): View|RedirectResponse
    {
        $current_date = $this->getDateOfCurrentCartoon();
        $last_archived = $this->getDateOfLastArchivedCartoon();
        // Make sure that no unpublished cartoons get shown
        if ($date > $current_date) {
            abort(404);
        }
        // Redirect to cartoon page for current date
        if ($date == $current_date) {
            return redirect(action([CartoonsController::class, 'showCurrent']));
        }
        // Make sure no older cartoons than allowed are shown
        if ($date < $last_archived) {
            abort(404);
        }
        // Search cartoon for the given date
        $cartoon = PublicationDate::where('publish_on', '=', $date)->first()->cartoon;
        // Show 404 if the cartoon is not found
        if (!$cartoon) {
            abort(404);
        }
        $cartoon->showRebusSolution = true;

        return view('cartoons.show', [
            'title' => 'Archiv',
            'pagetitle' => 'Cartoon der Woche . . . vom '.Carbon::parse($date)->locale('de')->isoFormat('Do MMMM YYYY'),
            'keywords' => 'Tetsche, Kalauseite, Cartoon, Kalau-Archiv, Archiv',
            'description' => 'Archiv - ältere Ausgaben',
            'cartoon' => $cartoon,
        ]);
    }

    /**
     * Helper method to determine the current cartoon.
     */
    private function getDateOfCurrentCartoon()
    {
        // Add 6 hours to the current time, so that the
        // cartoon is published at 18:00 one day before.
        $date = date('Y-m-d', time() + 6 * 60 * 60);
        $current_cartoon = PublicationDate::where('publish_on', '<=', $date)
            ->orderBy('publish_on', 'DESC')
            ->first();

        return $current_cartoon->publish_on;
    }

    /**
     * Helper method to determine the last archived cartoon.
     *
     * There should be only 16 cartoons in the archive.
     */
    private function getDateOfLastArchivedCartoon()
    {
        $current = $this->getDateOfCurrentCartoon();

        return PublicationDate::where('publish_on', '<=', $current)
            ->orderBy('publish_on', 'desc')
            ->skip(16)
            ->value('publish_on');
    }

    /**
     * Display the current cartoon.
     */
    public function showCurrent(): View
    {
        $date = $this->getDateOfCurrentCartoon();
        $cartoon = PublicationDate::where('publish_on', '=', $date)->first()->cartoon;
        $cartoon->showRebusSolution = false;

        return view('cartoons.show', [
            'title' => 'Cartoon der Woche',
            'pagetitle' => 'Cartoon der Woche . . . vom '.Carbon::parse($date)->locale('de')->isoFormat('Do MMMM YYYY'),
            'keywords' => 'Tetsche, Cartoon der Woche',
            'description' => 'Tetsche - Cartoon der Woche',
            'cartoon' => $cartoon,
        ]);
    }

    /**
     * Display a listing of the archive.
     */
    public function showArchive(): View
    {
        $date = $this->getDateOfCurrentCartoon();
        $last_archived = $this->getDateOfLastArchivedCartoon();
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

    ///////////////////////////////////
    // Helper methods
    ///////////////////////////////////

    /**
     * Force a new randomly selected cartoon for next thursday.
     */
    public function forceNewCartoon()
    {
        $newest_cartoon = PublicationDate::orderBy('publish_on', 'desc')->first();
        $newest_cartoon_date = $newest_cartoon->publish_on;
        $current_date = $this->getDateOfCurrentCartoon();
        if ($newest_cartoon_date > $current_date) {
            $newest_cartoon->delete();
            $this->checkIfCurrentIsLastCartoon();
        }

        return redirect('cartoons');
    }

    /**
     * Check if the current cartoon is the last one.
     * If so, generate a new random number for the next
     * cartoon, and check for some special cases.
     */
    public function checkIfCurrentIsLastCartoon(): RedirectResponse
    {
        $newest_cartoon = PublicationDate::orderBy('publish_on', 'desc')->first();
        $newest_cartoon_date = $newest_cartoon->publish_on;
        $current_date = $this->getDateOfCurrentCartoon();
        // If there are no more cartoons for next week,
        // generate a "random" number.
        if ($current_date >= $newest_cartoon_date) {
            // First, get all cartoon ids which have been shown
            // less than two years ago, so they can be omitted.
            $two_years_ago = date("Y-m-d", time() - 2 * 365 * 24 * 60 * 60);
            $recent_cartoon_ids = PublicationDate::where('publish_on', '<=', $newest_cartoon_date)
                ->where('publish_on', '>=', $two_years_ago)
                ->orderBy('publish_on', 'DESC')
                ->get()->pluck('cartoon_id')->all();

            // Next, get all available cartoon ids.
            $all_cartoon_ids = Cartoon::all()->pluck('id')->all();

            // This is for cartoons which should not be shown again,
            // e.g. because of contemporary events or similar.
            $dont_show_again_ids = [320];

            // Define some ids for special cases:
            $weihnachten_ids = [49, 51, 52, 104, 157, 159, 216, 218, 276, 277, 331];
            $silvester_ids = [160, 219, 278];
            $neujahr_ids = [1, 53, 105, 161, 221, 279];
            $ostern_ids = [13, 68, 118, 176, 236, 291];
            $all_special_ids = array_merge(
                $weihnachten_ids,
                $silvester_ids,
                $neujahr_ids,
                $ostern_ids
            );
            sort($all_special_ids);

            // Determine the next thursday
            $publish_on = $this->getThursday();

            // Determine if any of the special ids should be chosen
            // instead of a normal cartoon.

            // Weihnachten
            $thursday_before_weihnachten = $this->getThursday("last", date("Y-12-24"));
            if ($publish_on == $thursday_before_weihnachten) {
                $all_cartoon_ids = $weihnachten_ids;
                $all_special_ids = [];
            }

            // Silvester
            $thursday_before_silvester = $this->getThursday("last", date("Y-12-31"));
            if ($publish_on == $thursday_before_silvester) {
                $all_cartoon_ids = $silvester_ids;
                $all_special_ids = [];
            }

            // Neujahr
            $thursday_after_neujahr = $this->getThursday("last", ((int)date("Y") + 1)."-01-07");
            if ($publish_on == $thursday_after_neujahr) {
                $all_cartoon_ids = $neujahr_ids;
                $all_special_ids = [];
            }

            // Ostern
            $thursday_before_ostern = new DateTime(date("Y")."-03-21");
            // Returns the number of days after March 21 on which Easter falls.
            $thursday_before_ostern->add(new DateInterval('P'.easter_days().'D'));
            $thursday_before_ostern = $thursday_before_ostern->format("Y-m-d");
            $thursday_before_ostern = $this->getThursday("last", $thursday_before_ostern);
            if ($publish_on == $thursday_before_ostern) {
                $all_cartoon_ids = $ostern_ids;
                $all_special_ids = [];
            }

            // Generate a random number and ensure that the chosen id
            // is in the array of valid cartoon ids and also not
            // in the array of recently shown cartoons or special cartoons.
            $min_number = min($all_cartoon_ids);
            $max_number = max($all_cartoon_ids);
            while (true) {
                $random_id = mt_rand($min_number, $max_number);
                if (in_array($random_id, $all_cartoon_ids)
                    and !in_array($random_id, $recent_cartoon_ids)
                    and !in_array($random_id, $all_special_ids)
                    and !in_array($random_id, $dont_show_again_ids)) {
                    break;
                }
            }

            // Ensure that the publication date does not yet exist.
            $date_exists = PublicationDate::where('publish_on', $publish_on)->first();
            if (!$date_exists) {
                PublicationDate::create([
                    'publish_on' => $publish_on,
                    'cartoon_id' => $random_id,
                ]);
            }
        }

        return redirect(action([CartoonsController::class, 'showCurrent']));
    }

    /**
     * Helper method to determine the last or the next thursday.
     *
     * @param $which string with either "next" or "last".
     * @param $date string with a date, defaults to current date.
     */
    private function getThursday($which = "next", $date = ""): string
    {
        if ($date == "") {
            $date = date("Y-m-d");
        }

        $offset = 1;
        if ($which == "last") {
            $offset = -1;
        }
        list($year, $month, $day) = explode('-', $date);
        while (date("w", mktime(0, 0, 0, $month, $day, $year)) != 4) {
            $day = $day + $offset;
        }
        // Construct and explode the date again to cope with
        // overflows (e.g. 2015-03-35) and get a valid date
        $thursday = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));

        return $thursday;
    }
}
