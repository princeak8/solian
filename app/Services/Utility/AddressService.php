<?php

namespace App\Services\Utility;

use DB;
use Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Address;
use App\Models\User;

class AddressService
{

    public function address($id)
    {
        return Address::find($id);
    }

    public function save($data)
    {
        $address = new Address;
        if(isset($data['street_address'])) $address->street_address = $data['street_address'];
        if(isset($data['city'])) $address->city           = $data['city'];
        if(isset($data['country_id'])) $address->country_id     = $data['country_id'];
        if(isset($data['postal_code'])) $address->postal_code    = $data['postal_code'];
        $address->save();
        return $address;
    }

    //public function updatePhoto($file, $photo)
}

?>