<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Cartoon;
use App\Models\PublicationDate;
use App\Services\Cartoons;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class NewCartoonController extends Controller
{
    /**
     * Force a new randomly selected cartoon for next thursday.
     */
    public function forceNewCartoon(): RedirectResponse
    {
        $newest_cartoon = PublicationDate::latest('publish_on')->first();
        if ($newest_cartoon === null) {
            return to_route('publication_dates.index');
        }
        $current = PublicationDate::getCurrent();
        if ($newest_cartoon->isNot($current)) {
            $newest_cartoon->delete();
            $this->checkIfCurrentIsLastCartoon();
        }

        return to_route('publication_dates.index');
    }

    /**
     * Check if the current cartoon is the last one.
     * If so, generate a new random number for the next
     * cartoon, and check for some special cases.
     */
    public function checkIfCurrentIsLastCartoon(Cartoons $cartoons): RedirectResponse
    {
        $newest_cartoon = PublicationDate::latest('publish_on')->first();
        if ($newest_cartoon === null) {
            return redirect()->action(CartoonsController::class);
        }
        $newest_cartoon_date = $newest_cartoon->publish_on;
        $current_date = PublicationDate::getCurrent();
        // If there are no more cartoons for next week,
        // generate a "random" number.
        if ($current_date->publish_on >= $newest_cartoon_date) {
            // First, get all cartoon ids which have been shown
            // less than two years ago, so they can be omitted.
            $two_years_ago = Carbon::now()
                ->subYears(2)
                ->format('Y-m-d');
            $recent_cartoon_ids = PublicationDate::where('publish_on', '>=', $two_years_ago)
                ->pluck('cartoon_id')
                ->all();

            // Next, get all available cartoon ids.
            $all_cartoon_ids = Cartoon::pluck('id')
                ->all();

            // This is for cartoons which should not be shown again,
            // e.g. because of contemporary events or similar.
            $dont_show_again_ids = [320];

            // Define some ids for special cases:
            $weihnachten_ids = [
                49, 51, 52, 104, 157, 159, 216, 218, 276, 277, 331,
            ];
            $silvester_ids = [160, 219, 278];
            $neujahr_ids = [1, 53, 105, 161, 221, 279];
            $ostern_ids = [13, 68, 118, 176, 236, 291];
            $all_special_ids = array_merge(
                $weihnachten_ids,
                $silvester_ids,
                $neujahr_ids,
                $ostern_ids,
            );
            sort($all_special_ids);

            // Determine the next thursday
            $publish_on = $cartoons->getNextThursday();

            // Determine if any of the special ids should be chosen
            // instead of a normal cartoon.

            // Weihnachten
            $thursday_before_weihnachten = $cartoons->getLastThursday(
                Carbon::createFromDate(null, 12, 24)->format('Y-m-d')
            );
            if ($publish_on == $thursday_before_weihnachten) {
                $all_cartoon_ids = $weihnachten_ids;
                $all_special_ids = [];
            }

            // Silvester
            $thursday_before_silvester = $cartoons->getLastThursday(
                Carbon::createFromDate(null, 12, 31)->format('Y-m-d')
            );
            if ($publish_on == $thursday_before_silvester) {
                $all_cartoon_ids = $silvester_ids;
                $all_special_ids = [];
            }

            // Neujahr
            $thursday_after_neujahr = $cartoons->getLastThursday(
                Carbon::createFromDate(null, 1, 7)->addYear()->format('Y-m-d')
            );
            if ($publish_on == $thursday_after_neujahr) {
                $all_cartoon_ids = $neujahr_ids;
                $all_special_ids = [];
            }

            // Ostern
            // Returns the number of days after March 21 on which Easter falls.
            $thursday_before_ostern = $cartoons->getLastThursday(
                Carbon::createFromDate(null, 3, 21)
                    ->addDays(easter_days())
                    ->format('Y-m-d')
            );
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
                if (
                    in_array($random_id, $all_cartoon_ids) and
                    ! in_array($random_id, $recent_cartoon_ids) and
                    ! in_array($random_id, $all_special_ids) and
                    ! in_array($random_id, $dont_show_again_ids)
                ) {
                    break;
                }
            }

            // Ensure that the publication date does not yet exist.
            $date_exists = PublicationDate::where(
                'publish_on',
                $publish_on,
            )->first();
            if (! $date_exists) {
                PublicationDate::create([
                    'publish_on' => $publish_on,
                    'cartoon_id' => $random_id,
                ]);
            }
        }

        return redirect()->action(CartoonsController::class);
    }
}
