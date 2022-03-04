<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_status extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function status($status)
    {
        return Self::where('status', $status)->first();
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'payment_status_id', 'id');
    }
}
