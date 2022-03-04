<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_status extends Model
{
    use HasFactory;

    protected $table = 'order_statuses';

    public static function status($status)
    {
        return Self::where('status', $status)->first();
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'order_status_id', 'id');
    }
}
