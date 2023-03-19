<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bus\StoreRequest;
use App\Http\Requests\Bus\UpdateRequest;
use App\Models\Bus;
use App\Models\Seat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return response()->view('buses.index', [
            'buses' => Bus::orderBy('updated_at', 'desc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('buses.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // insert only requests that already validated in the StoreRequest
        $create = Bus::create($validated);
        SeatController::generateSeats($request->available_seats,$create->id);

        if($create) {
            // add flash for the success notification
            session()->flash('notify.success', 'Bus created successfully!');
            return redirect()->route('buses.index');
        }

        return abort(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        return response()->view('buses.show', [
            'bus' => Bus::findOrFail($id),
            'seats'  => Seat::where('bus_id',$id)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        return response()->view('buses.form', [
            'bus' => Bus::findOrFail($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id): RedirectResponse
    {
        $bus = Bus::findOrFail($id);
        $validated = $request->validated();

        $update = $bus->update([
            'name'=>$validated['name']
        ]);

        if($update) {
            session()->flash('notify.success', 'Bus updated successfully!');
            return redirect()->route('buses.index');
        }

        return abort(500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $bus = Bus::findOrFail($id);

        $delete = $bus->delete($id);

        if($delete) {
            session()->flash('notify.success', 'Bus deleted successfully!');
            return redirect()->route('buses.index');
        }

        return abort(500);
    }

}
