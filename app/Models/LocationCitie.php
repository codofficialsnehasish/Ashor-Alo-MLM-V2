<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationCitie extends Model
{
    /**
     * Get the country that this city belongs to
     */
    public function country()
    {
        return $this->belongsTo(LocationCountrie::class, 'country_id');
    }

    /**
     * Get the state that this city belongs to
     */
    public function state()
    {
        return $this->belongsTo(LocationState::class, 'state_id');
    }
}
