<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\LocationCountrie;
use App\Models\LocationState;
use App\Models\LocationCitie;

class LocationApiController extends Controller
{
    /**
     * Get all visible countries
     */
    public function getCountries(Request $request)
    {
        $countries = LocationCountrie::where('is_visible', 1)->get();

        return apiResponse(true, 'All visible countries fetched successfully.', ['countries'=>$countries], 200);
    }

    /**
     * Get states for a specific country or all visible states
     */
    public function getStates($country_id = null)
    {
        if ($country_id !== null) {
            $country = LocationCountrie::find($country_id);

            if (!$country) {
                return apiResponse(false, 'Invalid country ID.', null, 200);
            }

            $states = LocationState::where('country_id', $country_id)
                ->where('is_visible', 1)
                ->get();

            return apiResponse(true, 'States for ' . $country->name . ' fetched successfully.', [
                'country' => $country,
                'states' => $states,
            ], 200);
        }

        // If no country_id is provided, return all visible states
        $states = LocationState::where('is_visible', 1)->get();

        return apiResponse(true, 'All visible states fetched successfully.', ['states' => $states], 200);
    }


    /**
     * Get cities for a specific state or all visible cities 
     */
    public function getCities($state_id = null)
    {
        if ($state_id !== null) {
            $state = LocationState::find($state_id);

            if (!$state) {
                return apiResponse(false, 'Invalid state ID.', null, 200);
            }

            $cities = LocationCitie::where('state_id', $state_id)
                ->where('is_visible', 1)
                ->get();

            $message = 'Cities for ' . $state->name . ' fetched successfully.';

            return apiResponse(true, $message, [
                'state' => $state,
                'cities' => $cities,
            ], 200);
        }

        $cities = LocationCitie::where('is_visible', 1)->paginate(10);

        return apiResponse(true, 'All visible cities fetched successfully.', ['cities' => $cities], 200);
    }

}