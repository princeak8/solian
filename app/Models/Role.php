<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role'];

    public static function superAdminRole()
    {
        return Self::where('role', 'admin')->orWhere('role', 'super admin')->first();
    }

    public static function adminRole()
    {
        return Self::where('role', 'admin')->orWhere('role', 'admin')->first();
    }

    public static function customerRole()
    {
        return Self::where('role', 'customer')->first();
    }

    public static function role($role)
    {
        return Self::where('role', $role)->first();
    }

    public function users()
    {
        return $this->hasMany('App\Models\User', 'role_id', 'id');
    }


}
