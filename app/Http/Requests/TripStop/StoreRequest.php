<?php

namespace App\Http\Requests\TripStop;

use App\Models\Trip;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
        $trip = Trip::find($this->trip_id);
        $start_station_id = $trip->start_station_id;
        $end_station_id = $trip->end_station_id;

        return [
            'trip_id' => 'required|exists:trips,id',
            'station_id' => ['required',Rule::notIn([$start_station_id, $end_station_id])]
        ];
    }
}
