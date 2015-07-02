<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function homepage()
    {
        return view('pages.homepage');
    }

    public function tetsche()
    {
        return view('pages.tetsche');
    }

    public function impressum()
    {
        return view('pages.impressum');
    }
}
