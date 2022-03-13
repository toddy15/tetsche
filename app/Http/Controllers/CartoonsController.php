<?php

namespace App\Http\Controllers;

use App\Cartoon;
use App\PublicationDate;

use Carbon\Carbon;
use Illuminate\Http\Request;

class CartoonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $next_thursday = $this->getThursday("next");
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
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Check for an uploaded file
        if ($request->hasFile('image') and $request->file('image')->isValid()) {
            $cartoon = new Cartoon();
            // Construct the publish date
            $cartoon->publish_on = sprintf(
                "%04d-%02d-%02d",
                $request->input('year'),
                $request->input('month'),
                $request->input('day')
            );
            $cartoon->rebus = $request->input('rebus');
            $cartoon->random_number = substr(mt_rand(100000, 999999), 1, 5);
            // Save the uploaded file to a temp name
            $destination_path = public_path() . '/images/cartoons/';
            $tmp_filename = $cartoon->publish_on;
            $tmp_filename .= '.upload.';
            $tmp_filename .= $cartoon->random_number;
            $tmp_filename .= '.jpg';
            $request->file('image')->move($destination_path, $tmp_filename);
            // Now get the absolute path for the tmp_filename
            $tmp_filename = $destination_path . $tmp_filename;
            // Create an image without metadata by copying it into a new image
            // and create a thumbnail
            $original_filename = str_replace(".upload.", ".cartoon.", $tmp_filename);
            $small_filename = str_replace(".upload.", ".thumbnail.", $tmp_filename);
            // Read the uploaded image
            $tmp_image = @imagecreatefromjpeg($tmp_filename);
            // Calculate the height for a thumbnail with 220 pixel width
            $height = 220 * imagesy($tmp_image) / imagesx($tmp_image);
            // Create blank images
            $original_image = imagecreatetruecolor(imagesx($tmp_image), imagesy($tmp_image));
            $small_image = imagecreatetruecolor(220, $height);
            $white = imagecolorallocate($small_image, 255, 255, 255);
            imagefill($small_image, 0, 0, $white);
            // Copy the images
            imagecopy($original_image, $tmp_image, 0, 0, 0, 0, imagesx($tmp_image), imagesy($tmp_image));
            imagecopyresampled($small_image, $tmp_image, 0, 0, 0, 0, 220, $height, imagesx($tmp_image), imagesy($tmp_image));
            // Write the images with 85% quality
            imagejpeg($original_image, $original_filename, 85);
            imagejpeg($small_image, $small_filename, 85);
            imagedestroy($original_image);
            imagedestroy($small_image);
            // Remove the uploaded file, it's no longer needed.
            unlink($tmp_filename);
            $cartoon->save();
            $request->session()->flash('info', 'Der Cartoon wurde gespeichert.');

            return redirect(action('CartoonsController@index'));
        } else {
            $request->session()->flash(
                'error',
                'Die Datei für den Cartoon wurde nicht hochgeladen. ' .
                'Entweder wurde keine Datei ausgewählt oder die ausgewählte Datei ist zu groß.'
            );

            return redirect('cartoons/neu')->withInput();
        }
    }

    /**
     * Display an archived cartoon.
     *
     * @return \Illuminate\View\View
     */
    public function show($date)
    {
        $current_date = $this->getDateOfCurrentCartoon();
        $last_archived = $this->getDateOfLastArchivedCartoon();
        // Make sure that no unpublished cartoons get shown
        if ($date > $current_date) {
            abort(404);
        }
        // Redirect to cartoon page for current date
        if ($date == $current_date) {
            return redirect(action('CartoonsController@showCurrent'));
        }
        // Make sure no older cartoons than allowed are shown
        if ($date < $last_archived) {
            abort(404);
        }
        // Search cartoon for the given date
        $cartoon = PublicationDate::where('publish_on', '=', $date)->first()->cartoon;
        // Show 404 if the cartoon is not found
        if (! $cartoon) {
            abort(404);
        }
        $cartoon->showRebusSolution = true;

        return view('cartoons.show', [
            'title' => 'Archiv',
            'pagetitle' => 'Cartoon der Woche . . . vom ' . Carbon::parse($date)->locale("de")->format('%e. %B %Y'),
            'keywords' => 'Tetsche, Kalauseite, Cartoon, Kalau-Archiv, Archiv',
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
        $cartoon = PublicationDate::where('publish_on', '=', $date)->first()->cartoon;
        $cartoon->showRebusSolution = false;

        return view('cartoons.show', [
            'title' => 'Cartoon der Woche',
            'pagetitle' => 'Cartoon der Woche . . . vom ' . Carbon::parse($date)->locale("de")->format('%e. %B %Y'),
            'keywords' => 'Tetsche, Kalauseite der Woche, Cartoon der Woche',
            'description' => 'Tetsche - Cartoon der Woche',
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
        $last_archived = $this->getDateOfLastArchivedCartoon();
        $dates = PublicationDate::where('publish_on', '<', $date)
            ->where('publish_on', '>=', $last_archived)
            ->orderBy('publish_on', 'desc')->simplePaginate(8);

        return view('cartoons.archive', [
            'title' => 'Archiv',
            'keywords' => 'Tetsche im »stern«, Kalauseite, Cartoon, Kalau-Archiv, Archiv',
            'description' => 'Archiv - ältere Ausgaben',
            'dates' => $dates,
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
        $cartoon = Cartoon::findOrFail($id);

        return view('cartoons.edit', [
            'title' => 'Cartoon bearbeiten',
            'cartoon' => $cartoon,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $cartoon = Cartoon::findOrFail($id);
        $cartoon->rebus = $request->input('rebus');
        $cartoon->save();
        $request->session()->flash('info', 'Die Rebuslösung wurde gespeichert.');

        return redirect('cartoons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $cartoon = Cartoon::findOrFail($id);
        unlink($cartoon->imagePath());
        unlink($cartoon->thumbnailPath());
        $cartoon->delete();
        $request->session()->flash('info', 'Der Cartoon wurde gelöscht.');

        return redirect('cartoons');
    }

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
    public function checkIfCurrentIsLastCartoon()
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

            // Define some ids for special cases:
            $weihnachten_ids = [49, 51, 52, 104, 157, 159, 216, 218, 276, 277, 331];
            $silvester_ids = [160, 219, 278];
            $neujahr_ids = [1, 53, 105, 161, 221, 279];
            $ostern_ids = [];
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
            $thursday_after_neujahr = $this->getThursday("last", date("Y") + 1 . "-01-07");
            if ($publish_on == $thursday_after_neujahr) {
                $all_cartoon_ids = $neujahr_ids;
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
                  and ! in_array($random_id, $recent_cartoon_ids)
                  and ! in_array($random_id, $all_special_ids)) {
                    break;
                }
            }

            // Ensure that the publication date does not yet exist.
            $date_exists = PublicationDate::where('publish_on', $publish_on)->first();
            if (! $date_exists) {
                PublicationDate::create([
                    'publish_on' => $publish_on,
                    'cartoon_id' => $random_id,
                ]);
            }
        }

        return redirect(action('CartoonsController@showCurrent'));
    }

    ///////////////////////////////////
    // Helper methods
    ///////////////////////////////////

    /**
     * Helper method to determine the last or the next thursday.
     *
     * @param $which string with either "next" or "last".
     * @param $date string with a date, defaults to current date.
     */
    private function getThursday($which = "next", $date = "")
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
}
