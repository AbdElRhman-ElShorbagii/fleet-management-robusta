<?php

namespace App\Http\Controllers;

use App\Http\Requests\TripStop\StoreRequest;
use App\Http\Requests\TripStop\UpdateRequest;
use App\Models\Station;
use App\Models\Trip;
use App\Models\TripStop;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TripStopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response()->view('tripStops.index', [
            'tripStops' => TripStop::with('trip','station')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('tripStops.form',[
            'stations' => Station::get(),
            'trips' => Trip::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // insert only requests that already validated in the StoreRequest
        $create = TripStop::create($validated);

        if($create) {
            // add flash for the success notification
            session()->flash('notify.success', 'Trip Stop created successfully!');
            return redirect()->route('trip-stops.index');
        }

        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        return response()->view('tripStops.show', [
            'tripStop' => TripStop::with('trip','station')->findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        return response()->view('tripStops.form', [
            'tripStop' => TripStop::with('trip','station')->findOrFail($id),
            'stations' => Station::get(),
            'trips' => Trip::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
        $tripStop = TripStop::findOrFail($id);
        $validated = $request->validated();

        $update = $tripStop->update($validated);

        if($update) {
            session()->flash('notify.success', 'Trip Stop updated successfully!');
            return redirect()->route('trip-stops.index');
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $tripStop = TripStop::findOrFail($id);
        
        $delete = $tripStop->delete($id);

        if($delete) {
            session()->flash('notify.success', 'Trip Stop deleted successfully!');
            return redirect()->route('trip-stops.index');
        }

        return abort(500);
    }
}
