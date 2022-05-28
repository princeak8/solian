<?php

namespace App\Services\Utility;

use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Helpers\Helper;

use App\Models\Role;


class RoleService
{

    public static function customerRole()
    {
        return Role::customerRole();
    }

    public static function adminRole()
    {
        return Role::adminRole();
    }

    public static function superAdminRole()
    {
        return Role::superAdminRole();
    }
}

?>