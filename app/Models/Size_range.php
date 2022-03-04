<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size_range extends Model
{
    use HasFactory;

    public function size()
    {
        return $this->belongsTo('App\Models\Size', 'size_id');
    }
    public function size_type()
    {
        return $this->belongsTo('App\Models\Size_type', 'size_type_id');
    }
}
