<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bus_id',
        'start_station_id',
        'end_station_id'
    ];

    public function startStation(): BelongsTo
    {
        return $this->belongsTo(Station::class,'start_station_id');
    }

    public function endStation(): BelongsTo
    {
        return $this->belongsTo(Station::class,'end_station_id');
    }

    public function stops(): HasMany
    {
        return $this->hasMany(TripStop::class);
    }

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
