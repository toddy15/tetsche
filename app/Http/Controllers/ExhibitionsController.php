<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Exhibition;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ExhibitionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $exhibitions = Exhibition::where('show_until', '>=', Carbon::now())
            ->oldest('show_until')
            ->get();

        return view('exhibitions.index', [
            'exhibitions' => $exhibitions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('exhibitions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExhibitionRequest $request): RedirectResponse
    {
        Exhibition::create($request->validated());

        return redirect()->route('ausstellungen.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exhibition $ausstellungen): View
    {
        return view('exhibitions.edit', [
            'exhibition' => $ausstellungen,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExhibitionRequest $request, Exhibition $ausstellungen): RedirectResponse
    {
        $ausstellungen->update($request->validated());
        $ausstellungen->save();

        return redirect()->route('ausstellungen.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exhibition $ausstellungen): RedirectResponse
    {
        $ausstellungen->delete();

        return redirect()->route('ausstellungen.index');
    }
}
