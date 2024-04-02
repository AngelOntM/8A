<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('chirps.index', [
            'chirps' => Chirp::latest()->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'min:3', 'max:255'],
        ]);

        $request->user()->chirps()->create($validated);

        return redirect()->intended(URL::signedRoute('chirps.index'))
            ->with('status', __('Chirp created successfully!'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {

        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {

        $validated = $request->validate([
            'message' => ['required', 'min:3', 'max:255'],
        ]);

        $chirp->update($validated);

        return redirect()->intended(URL::signedRoute('chirps.index'))
            ->with('status', __('Chirp updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {

        $chirp->delete();

        return redirect()->intended(URL::signedRoute('chirps.index'))
            ->with('status', __('Chirp deleted successfully!'));
    }
}