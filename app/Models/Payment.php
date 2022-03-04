<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo('App\Models\User', 'approved_by');
    }

    public function payment_mode()
    {
        return $this->belongsTo('App\Models\Payment_mode', 'payment_mode_id');
    }
}
