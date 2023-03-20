<?php

namespace App\Http\Controllers;

use App\Http\Requests\Reservation\CheckAvailableSeatRequest;
use App\Http\Requests\Reservation\MakeReservationRequest;
use App\Interfaces\ReservationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    private ReservationRepositoryInterface $reservationRepository;

    public function __construct(ReservationRepositoryInterface $reservationRepository) 
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function checkAvailableSeat(CheckAvailableSeatRequest $request)
    {
        return response()->json(
            $this->reservationRepository->checkAvailableSeat($request->trip_id,$request->from_station_id,$request->to_station_id)
        );
    }

    public function makeReservation(MakeReservationRequest $request) 
    {
        return response()->json(
            $this->reservationRepository->makeReservation($request->trip_id,$request->from_station_id,$request->to_station_id,$request->seat_id,Auth::id())
        );
    }

}
