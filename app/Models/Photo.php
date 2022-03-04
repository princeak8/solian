<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public static function slides()
    {
        $slides = Self::where('slide', '1')->get();
        $active = 0;
        if($slides->count() > 0) {
            foreach($slides as $slide) {
                if($active==1) {
                    $slide = 0;
                }else{
                    if($slide->main == 1) {
                        $active = 1;
                        $slide->active = 1;
                    }else{
                        $slide->active = 0;
                    }
                }
            }
            if($active==0) {
                $slides[0]->active = 1;
            }
        }
        return $slides;
    }
}
