<?php

namespace App\Http\Requests\Reservation;

use App\Models\Reservation;
use App\Models\Trip;
use App\Models\TripStop;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MakeReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        $this->checkReverseBooking();
        $this->checkOverlapping();
        $this->checkFullTripBookingEligibility();

        return [
            'from_station_id' => 'required|exists:stations,id',
            'to_station_id' => 'required|exists:stations,id',
            'trip_id' => 'required|exists:trips,id',
            'seat_id' => ['required',Rule::unique('reservations')->where(function ($query) {
                return $query->where('trip_id', $this->trip_id)
                ->where('from_station_id', $this->from_station_id)
                ->where('to_station_id', $this->to_station_id);
            }),]
        ];
    }

    public function checkOverlapping(): void
    {
        $reservations = Reservation::join('trip_stops','reservations.to_station_id','=','trip_stops.station_id')
        ->where('reservations.trip_id',$this->trip_id)
        ->where('reservations.seat_id',$this->seat_id)
        ->get();

        foreach($reservations as $reservation){
            $is_to_station_id_stop = TripStop::where('trip_id',$this->trip_id)->where('station_id',$this->to_station_id)->first();
            $is_from_station_id_stop = TripStop::where('trip_id',$this->trip_id)->where('station_id',$this->from_station_id)->first();
            if($is_to_station_id_stop){
                if($reservation->to_station_id < $this->to_station_id && $reservation->from_station_id == $this->from_station_id || $reservation->to_station_id > $this->to_station_id){
                    throw ValidationException::withMessages([
                        'seat_id' => 'The seat id has already been taken.',
                    ]);
                }
            }
            elseIf($is_from_station_id_stop){
                if($reservation->from_station_id < $this->from_station_id  && $reservation->to_station_id == $this->to_station_id || $reservation->to_station_id > $this->from_station_id){
                    throw ValidationException::withMessages([
                        'seat_id' => 'The seat id has already been taken.',
                    ]);
                }
            }
        }
    }


    public function checkFullTripBookingEligibility(): void
    {
        $trip = Trip::find($this->trip_id);
        if($this->from_station_id  == $trip->start_station_id  && $this->to_station_id  == $trip->end_station_id){
            $reservations = Reservation::where('reservations.trip_id',$this->trip_id)
            ->where('reservations.seat_id',$this->seat_id)
            ->first();
            // dd($reservations);
            if($reservations){
                throw ValidationException::withMessages([
                    'seat_id' => 'The seat id has already been taken.',
                ]);
            }
        }
        else{
            $reservations = Reservation::where('reservations.trip_id',$this->trip_id)
            ->where('from_station_id',$trip->start_station_id)
            ->where('to_station_id',$trip->end_station_id)
            ->where('reservations.seat_id',$this->seat_id)
            ->first();
            // dd($reservations);
            if($reservations){
                throw ValidationException::withMessages([
                    'seat_id' => 'The seat id has already been taken.',
                ]);
            }
        }
    }

    public function checkReverseBooking(): void
    {

        $to_station_id_stop = TripStop::where('trip_id',$this->trip_id)->where('station_id',$this->to_station_id)->first();
        $from_station_id_stop = TripStop::where('trip_id',$this->trip_id)->where('station_id',$this->from_station_id)->first();
        $trip = Trip::find($this->trip_id);

        if($from_station_id_stop && $to_station_id_stop){
            if($from_station_id_stop->id > $to_station_id_stop->id){
                throw ValidationException::withMessages([
                    'error' => 'reversed booking'
                ]);
            }
        }
        elseif($this->to_station_id == $trip->start_station_id  || $this->from_station_id == $trip->end_station_id)
        {
            throw ValidationException::withMessages([
                'error' => 'reversed booking'
            ]);
        }

    }


}
