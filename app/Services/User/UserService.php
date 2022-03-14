<?php

namespace App\Services\User;

use DB;
use Storage;
use Illuminate\Support\Facades\Auth;

use App\Models\Payment;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class UserService
{

    public function users()
    {
        return User::all();
    }

    public function user($id)
    {
        return User::find($id);
    }

    public function  isSuperAdmin($user)
    {
        return ($user->role->role == 'super admin');
    }

    //public function updatePhoto($file, $photo)
}

?>