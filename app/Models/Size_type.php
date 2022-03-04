<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size_type extends Model
{
    use HasFactory;

    public function sizes()
    {
        return $this->hasMany('App\Models\Size_range', 'size_type_id', 'id');
    }
}
