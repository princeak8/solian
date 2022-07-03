<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','email','password','role_id','phone_number'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getFirstnameAttribute()
    {
        if (isset($this->name)) {
            return explode(' ', $this->name)[0];
        }
        return '';
    }

    public function admins()
    {
        return Self::all()->where('role_id', Role::role('admin')->id);
    }

    public function customers()
    {
        return Self::all()->where('role_id', Role::role('customer')->id);
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'user_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment', 'user_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Address', 'address_id');
    }

    public static function boot ()
    {
        parent::boot();

        self::deleting(function (User $user) {

            foreach ($user->payments as $payment)
            {
                $payment->user_id = 0;
                $payment->update();
            }
        });
    }
}
