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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
