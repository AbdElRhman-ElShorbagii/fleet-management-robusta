<?php

namespace App\Http\Controllers;

use App\Http\Requests\Trip\UpdateRequest;
use App\Http\Requests\Trip\StoreRequest;
use App\Models\Bus;
use App\Models\Station;
use App\Models\Trip;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response()->view('trips.index', [
            'trips' => Trip::with('startStation','endStation','bus')->orderBy('updated_at', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('trips.form',[
            'stations' => Station::get(),
            'buses' => Bus::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // insert only requests that already validated in the StoreRequest
        $create = Trip::create($validated);

        if($create) {
            // add flash for the success notification
            session()->flash('notify.success', 'Trip created successfully!');
            return redirect()->route('trips.index');
        }

        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        return response()->view('trips.show', [
            'trip' => Trip::with('startStation','endStation','bus')->findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        return response()->view('trips.form', [
            'trip' => Trip::with('startStation','endStation','bus')->findOrFail($id),
            'stations' => Station::get(),
            'buses' => Bus::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
        $trip = Trip::findOrFail($id);
        $validated = $request->validated();

        $update = $trip->update($validated);

        if($update) {
            session()->flash('notify.success', 'Trip updated successfully!');
            return redirect()->route('trips.index');
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $trip = Trip::findOrFail($id);
        
        $delete = $trip->delete($id);

        if($delete) {
            session()->flash('notify.success', 'Trip deleted successfully!');
            return redirect()->route('trips.index');
        }

        return abort(500);
    }

}
