<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    static function generateSeats($available_seats, $bus_id): void
    {
        for ($i=0; $i < $available_seats; $i++) { 
            $seat = new Seat();
            $seat->bus_id = $bus_id;
            $seat->code = rand(100, 999).'-'.$bus_id;
            $seat->save();
        }
    }
}
