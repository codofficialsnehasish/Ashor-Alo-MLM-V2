<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationState extends Model
{
    /**
     * Get the country that owns this state
     */
    public function country()
    {
        return $this->belongsTo(LocationCountrie::class, 'country_id');
    }

    /**
     * Get all cities for this state
     */
    public function cities()
    {
        return $this->hasMany(LocationCitie::class, 'state_id');
    }
}
