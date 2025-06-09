<?php

namespace App\Livewire\Leaders;

use Livewire\Component;
use App\Models\User;
use App\Models\BinaryTree;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

use App\Models\LocationCountrie;
use App\Models\LocationState;
use App\Models\LocationCitie;
use Illuminate\Support\Facades\Gate;

class EditLeader extends Component
{
    public $leader;
    public $leaderId;
    public $sponsorId;
    public $sponsorName;
    public $name;
    public $father_or_husband_name;
    public $date_of_birth;
    public $gender;
    public $marital_status;
    public $phone;
    public $email;
    public $qualification;
    public $occupation;
    public $pin_code;
    public $shipping_address;
    public $address;
    public $country;
    public $state;
    public $city;
    public $nominee_name;
    public $nominee_relation;
    public $nominee_dob;
    public $nominee_address;
    public $nominee_state_id;
    public $nominee_city_id;
    public $account_name;
    public $bank_name;
    public $account_number;
    public $account_type;
    public $ifsc_code;
    public $pan_number;
    public $upi_name;
    public $upi_type;
    public $upi_number;
    public $password;
    public $status = 1;
    public $countries;
    public $states;
    public $cities;
    public $nominee_states;
    public $nominee_cities;

    protected $rules = [
        'name' => 'required|string|max:255',
        'phone' => 'required|digits:10|regex:/^[6789]/',
        'email' => 'required|email',
        'sponsorId' => 'required|exists:binary_trees,member_number',
    ];

    protected function checkPermission($permission)
    {
        if (!Gate::allows($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function mount($id)
    {
        try {
            // Decrypt the ID first
            $decryptedId = Crypt::decryptString($id);
            
            // Find the leader by member_number (not user ID)
            $this->leader = BinaryTree::where('user_id', $decryptedId)
                                    ->with('user')
                                    ->firstOrFail();
            
            $this->leaderId = $this->leader->member_number;
            
            // Load the rest of the data...
            $this->loadLeaderData();
            $this->loadSponsorInfo();
            $this->loadDropdownData();
            
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404, 'Invalid leader ID');
        }
    }

    protected function loadLeaderData()
    {
        $user = $this->leader->user;
        
        $this->name = $user->name;
        $this->father_or_husband_name = $user->profile?->father_or_husband_name;
        $this->date_of_birth = $user->profile?->date_of_birth;
        $this->gender = $user->profile?->gender;
        $this->marital_status = $user->profile?->marital_status;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->qualification = $user->profile?->qualification;
        $this->occupation = $user->profile?->occupation;
        $this->pin_code = $user->pin_code;
        $this->shipping_address = $user->shipping_address;
        $this->address = $user->address?->address;
        $this->country = $user->address?->country;
        $this->state = $user->address?->state;
        $this->city = $user->address?->city;
        $this->nominee_name = $user->nominee?->nominee_name;
        $this->nominee_relation = $user->nominee?->nominee_relation;
        $this->nominee_dob = $user->nominee?->nominee_dob;
        $this->nominee_address = $user->nominee?->nominee_address;
        $this->nominee_state_id = $user->nominee?->nominee_state_id;
        $this->nominee_city_id = $user->nominee?->nominee_city_id;
        $this->account_name = $user->bankDetails?->account_name;
        $this->bank_name = $user->bankDetails?->bank_name;
        $this->account_number = $user->bankDetails?->account_number;
        $this->account_type = $user->bankDetails?->account_type;
        $this->ifsc_code = $user->bankDetails?->ifsc_code;
        $this->pan_number = $user->profile?->pan_number;
        $this->upi_name = $user->bankDetails?->upi_name;
        $this->upi_type = $user->bankDetails?->upi_type;
        $this->upi_number = $user->bankDetails?->upi_number;
        $this->password = $user->decoded_password;
        $this->status = $user->status;
    }

    protected function loadSponsorInfo()
    {
        $sponsor = BinaryTree::find($this->leader->sponsor_id);
        if ($sponsor) {
            $this->sponsorId = $sponsor->member_number;
            $this->sponsorName = $sponsor->user->name;
        }
    }

    protected function loadDropdownData()
    {
        // Load countries, states, cities, etc. as needed
        $this->countries = LocationCountrie::all();
        $this->states = LocationState::where('country_id', $this->country)->get();
        $this->cities = LocationCitie::where('state_id', $this->state)->get();
        $this->nominee_states = LocationState::all();
        $this->nominee_cities = LocationCitie::where('state_id', $this->nominee_state_id)->get();
    }

    public function updatedCountry($value)
    {
        $this->states = LocationState::where('country_id', $value)->get();
        $this->state = null;
        $this->city = null;
    }

    public function updatedState($value)
    {
        $this->cities = LocationCitie::where('state_id', $value)->get();
        $this->city = null;
    }

    public function updatedNomineeStateId($value)
    {
        $this->nominee_cities = LocationCitie::where('state_id', $value)->get();
        $this->nominee_city_id = null;
    }

    public function getSponsorName()
    {
        $this->validateOnly('sponsorId', ['sponsorId' => 'required|exists:binary_trees,member_number']);
        
        $sponsor = BinaryTree::where('member_number', $this->sponsorId)->with('user')->first();
        $this->sponsorName = $sponsor ? $sponsor->user->name : 'Not found';
    }

    public function submitForm()
    {
        $this->checkPermission('Edit Leaders');
        $this->validate();

        $user = $this->leader->user;

        // Update core user fields
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'decoded_password' => $this->password,
            'status' => $this->status,
        ]);

        // Update profile
        $user->profile()->updateOrCreate([], [
            'father_or_husband_name' => $this->father_or_husband_name,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'marital_status' => $this->marital_status,
            'qualification' => $this->qualification,
            'occupation' => $this->occupation,
            'pan_number' => $this->pan_number,
        ]);

        // Update address
        $user->address()->updateOrCreate([], [
            'pin_code' => $this->pin_code,
            'shipping_address' => $this->shipping_address,
            'address' => $this->address,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
        ]);

        // Update bank details
        $user->bankDetails()->updateOrCreate([], [
            'account_name' => $this->account_name,
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'account_type' => $this->account_type,
            'ifsc_code' => $this->ifsc_code,
            'upi_name' => $this->upi_name,
            'upi_type' => $this->upi_type,
            'upi_number' => $this->upi_number,
        ]);

        // Update nominee
        $user->nominee()->updateOrCreate([], [
            'nominee_name' => $this->nominee_name,
            'nominee_relation' => $this->nominee_relation,
            'nominee_dob' => $this->nominee_dob,
            'nominee_address' => $this->nominee_address,
            'nominee_state_id' => $this->nominee_state_id,
            'nominee_city_id' => $this->nominee_city_id,
        ]);

        // Update sponsor if changed
        if ($this->sponsorId != $this->leader->sponsor_id) {
            $newSponsor = BinaryTree::where('member_number', $this->sponsorId)->first();
            if ($newSponsor) {
                $this->leader->update(['sponsor_id' => $newSponsor->id]);
            }
        }

        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'Leader updated successfully!'
        ]));
    }

    public function resetProfile()
    {
        
        // Reset profile information
        if ($this->leader->user->profile) {
            $this->leader->user->profile->update([
                'father_or_husband_name' => null,
                'date_of_birth' => null,
                'gender' => null,
                'marital_status' => null,
                'qualification' => null,
                'occupation' => null,
                'pan_number' => null,
            ]);
        }
        
        // Reset address information
        if ($this->leader->user->address) {
            $this->leader->user->address->update([
                'pin_code' => null,
                'shipping_address' => null,
                'address' => null,
                'country' => null,
                'state' => null,
                'city' => null,
            ]);
        }
        
        // Reset bank details
        if ($this->leader->user->bankDetails) {
            $this->leader->user->bankDetails->update([
                'account_name' => null,
                'bank_name' => null,
                'account_number' => null,
                'account_type' => null,
                'ifsc_code' => null,
                'upi_name' => null,
                'upi_type' => null,
                'upi_number' => null,
            ]);
        }
        
        // Reset nominee information
        if ($this->leader->user->nominee) {
            $this->leader->user->nominee->update([
                'nominee_name' => null,
                'nominee_relation' => null,
                'nominee_dob' => null,
                'nominee_address' => null,
                'nominee_state_id' => null,
                'nominee_city_id' => null,
            ]);
        }
        
        // Refresh component data
        $this->loadLeaderData();
        
        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'Profile has been reset successfully'
        ]));
    }


    public function render()
    {
        $this->checkPermission('Edit Leaders');
        return view('livewire.leaders.edit-leader');
    }
}