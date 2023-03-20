<?php

namespace App\Interfaces;

interface ReservationRepositoryInterface 
{
    public function checkAvailableSeat($trip_id,$from_station_id,$to_station_id);
    public function makeReservation($trip_id,$from_station_id,$to_station_id,$seat_id,$user_id);
}