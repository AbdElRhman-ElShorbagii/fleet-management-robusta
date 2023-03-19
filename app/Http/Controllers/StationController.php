<?php

namespace App\Http\Controllers;

use App\Http\Requests\Station\StoreRequest;
use App\Http\Requests\Station\UpdateRequest;
use App\Models\Station;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response()->view('stations.index', [
            'stations' => Station::orderBy('updated_at', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('stations.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // insert only requests that already validated in the StoreRequest
        $create = Station::create($validated);

        if($create) {
            // add flash for the success notification
            session()->flash('notify.success', 'Station created successfully!');
            return redirect()->route('stations.index');
        }

        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        return response()->view('stations.show', [
            'station' => Station::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        return response()->view('stations.form', [
            'station' => Station::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
        $station = Station::findOrFail($id);
        $validated = $request->validated();

        $update = $station->update($validated);

        if($update) {
            session()->flash('notify.success', 'Station updated successfully!');
            return redirect()->route('stations.index');
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $station = Station::findOrFail($id);
        
        $delete = $station->delete($id);

        if($delete) {
            session()->flash('notify.success', 'Station deleted successfully!');
            return redirect()->route('stations.index');
        }

        return abort(500);
    }
}
