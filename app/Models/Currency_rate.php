<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency_rate extends Model
{
    use HasFactory;

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_id');
    }
}
