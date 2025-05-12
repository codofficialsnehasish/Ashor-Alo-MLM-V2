<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationCountrie extends Model
{
    /**
     * Get all states for this country
     */
    public function states()
    {
        return $this->hasMany(LocationState::class, 'country_id');
    }

    /**
     * Get all cities for this country
     */
    public function cities()
    {
        return $this->hasMany(LocationCitie::class, 'country_id');
    }
}
