<?php

namespace App\Repositories;

use App\Interfaces\ReservationRepositoryInterface;
use App\Models\Reservation;
use App\Models\Seat;
use App\Models\Trip;
use App\Models\TripStop;
use Illuminate\Database\Eloquent\Collection;

class ReservationRepository implements ReservationRepositoryInterface 
{
    public function checkAvailableSeat($trip_id,$from_station_id,$to_station_id)
    { 
        $trip = Trip::find($trip_id);
        $available_seats = $trip->bus->available_seats;
        $full_trip_reservations = Reservation::where('trip_id',$trip_id)->where('from_station_id',$trip->start_station_id)->where('to_station_id',$trip->end_station_id)->pluck('seat_id');
        $full_trip_reservations_arr = json_decode($full_trip_reservations);

        // $full_reservations_count = Reservation::where('trip_id',$trip->id)->where('from_station_id',$trip->start_station_id)->where('to_station_id',$trip->end_station_id)->count();

        $is_going_from_start_to_end_station = Trip::where('id',$trip_id)->where('start_station_id',$from_station_id)->where('end_station_id',$to_station_id)->first();
        // dd($is_going_from_start_to_end_station);

        $is_going_from_start_to_stop_station = $trip->stops->where('station_id',$to_station_id)->first();
        // dd($is_going_from_start_to_stop_station);

        $is_going_from_stop_to_end_station = $trip->stops->where('station_id',$from_station_id)->first();
        // dd($is_going_from_stop_to_end_station);

        $from_stop = $trip->stops->where('station_id',$from_station_id)->first();
        $to_stop = $trip->stops->where('station_id',$to_station_id)->first();
        if($from_stop && $to_stop){
            $is_going_from_stop_to_stop = true;
        }
        else{
            $is_going_from_stop_to_stop = false;
        }
        // dd($is_going_from_stop_to_stop);


        if($is_going_from_start_to_end_station){
            $reserved_seats = Reservation::where('trip_id',$trip_id)->pluck('seat_id');
            $open_seats = Seat::whereNotIn('id',$reserved_seats)->get();

        }
        elseif($is_going_from_start_to_stop_station){
            $reserved_seats = Reservation::where('trip_id',$trip_id)
            ->where('from_station_id',$from_station_id)
            ->where('to_station_id',$to_station_id)
            ->pluck('seat_id');

            $reserved_seats_arr = json_decode($reserved_seats);
            $merged_seats = array_merge($full_trip_reservations_arr, $reserved_seats_arr);
            $open_seats = Seat::whereNotIn('id',$merged_seats)->get();
        }
        elseif($is_going_from_stop_to_end_station){
            $reserved_seats = Reservation::where('trip_id',$trip_id)
            ->where('from_station_id',$from_station_id)
            ->where('to_station_id',$to_station_id)
            ->pluck('seat_id');

            $reserved_seats_arr = json_decode($reserved_seats);
            $merged_seats = array_merge($full_trip_reservations_arr, $reserved_seats_arr);
            $open_seats = Seat::whereNotIn('id',$merged_seats)->get();
            return $open_seats;
        }
        elseif($is_going_from_stop_to_stop){

        }
        return $open_seats;
    }

    public function makeReservation($trip_id,$from_station_id,$to_station_id,$seat_id,$user_id) 
    {
        $reservation = new Reservation();
        $reservation->trip_id = $trip_id;
        $reservation->seat_id = $seat_id;
        $reservation->user_id = $user_id;
        $reservation->from_station_id = $from_station_id;
        $reservation->to_station_id = $to_station_id;
        $reservation->save();

        return $reservation;
    }
}
