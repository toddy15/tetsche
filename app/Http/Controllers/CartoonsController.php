<?php

namespace App\Http\Controllers;

use App\Cartoon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

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
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Check for an uploaded file
        if ($request->hasFile('image') and $request->file('image')->isValid()) {
            $cartoon = new Cartoon;
            // Construct the publish date
            $cartoon->publish_on = sprintf("%04d-%02d-%02d",
                $request->input('year'),
                $request->input('month'),
                $request->input('day'));
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
        }
        else {
            $request->session()->flash('error',
                'Die Datei für den Cartoon wurde nicht hochgeladen. ' .
                'Entweder wurde keine Datei ausgewählt oder die ausgewählte Datei ist zu groß.');
            return redirect('cartoons/neu')->withInput();
        }
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
     * Check if the current cartoon is the last one. If so, send an e-mail.
     */
    public function checkIfCurrentIsLastCartoon()
    {
        $newest_cartoon = Cartoon::orderBy('publish_on', 'desc')->first();
        $newest_cartoon_date = $newest_cartoon->publish_on;
        $current_date = date('Y-m-d');
        if ($current_date >= $newest_cartoon_date) {
            Mail::queue(['text' => 'emails.cartoon'], ['date' => $newest_cartoon_date], function($message) {
                $message->from('webmaster@tetsche.de', 'DSW');
                $message->to('tetsche@example.org', 'Tetsche');
                $message->to('toddy@example.org', 'Toddy');
                $message->subject('Nächste Tetsche-Seite fehlt');
            });
        }
        return redirect(action('CartoonsController@showCurrent'));
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
