<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

use App\Models\Size;
use App\Models\Size_range;
use App\Models\Size_type;

class SizeRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $xsSize = Size::where('size', 'XS')->first();
        $sSize = Size::where('size', 'S')->first();
        $mSize = Size::where('size', 'M')->first();
        $lSize = Size::where('size', 'L')->first();
        $xlSize = Size::where('size', 'XL')->first();
        $xxlSize = Size::where('size', 'XXL')->first();
        $xxxlSize = Size::where('size', 'XXXL')->first();
        $xxxxlSize = Size::where('size', 'XXXXL')->first();

        $USsizeType = Size_type::where('type', 'US SIZE')->first();
        $chestType = Size_type::where('type', 'CHEST')->first();
        $waistType = Size_type::where('type', 'WAIST')->first();
        $hipType = Size_type::where('type', 'HIP')->first(); 

        $size_ranges = [
            [
                "size_id" => $xsSize->id, "size_type_id" => $USsizeType->id, "min" => 0, "max" => 2
            ],
            [
                "size_id" => $xsSize->id, "size_type_id" => $chestType->id, "min" => 31, "max" => 33
            ],
            [
                "size_id" => $xsSize->id, "size_type_id" => $waistType->id, "min" => 23, "max" => 25
            ],
            [
                "size_id" => $xsSize->id, "size_type_id" => $hipType->id, "min" => 33, "max" => 37
            ],
            
            [
                "size_id" => $sSize->id, "size_type_id" => $USsizeType->id, "min" => 4, "max" => 6
            ],
            [
                "size_id" => $sSize->id, "size_type_id" => $chestType->id, "min" => 34, "max" => 36
            ],
            [
                "size_id" => $sSize->id, "size_type_id" => $waistType->id, "min" => 26, "max" => 28
            ],
            [
                "size_id" => $sSize->id, "size_type_id" => $hipType->id, "min" => 36, "max" => 38
            ],
            
            [
                "size_id" => $mSize->id, "size_type_id" => $USsizeType->id, "min" => 8, "max" => 10
            ],
            [
                "size_id" => $mSize->id, "size_type_id" => $chestType->id, "min" => 37, "max" => 39
            ],
            [
                "size_id" => $mSize->id, "size_type_id" => $waistType->id, "min" => 29, "max" => 31
            ],
            [
                "size_id" => $mSize->id, "size_type_id" => $hipType->id, "min" => 39, "max" => 41
            ],
            
            [
                "size_id" => $lSize->id, "size_type_id" => $USsizeType->id, "min" => 12, "max" => 14
            ],
            [
                "size_id" => $lSize->id, "size_type_id" => $chestType->id, "min" => 40, "max" => 42
            ],
            [
                "size_id" => $lSize->id, "size_type_id" => $waistType->id, "min" => 32, "max" => 34
            ],
            [
                "size_id" => $lSize->id, "size_type_id" => $hipType->id, "min" => 42, "max" => 44
            ],
            
            [
                "size_id" => $xlSize->id, "size_type_id" => $USsizeType->id, "min" => 46, "max" => 48
            ],
            [
                "size_id" => $xlSize->id, "size_type_id" => $chestType->id, "min" => 36, "max" => 38
            ],
            [
                "size_id" => $xlSize->id, "size_type_id" => $waistType->id, "min" => 43, "max" => 45
            ],
            [
                "size_id" => $xlSize->id, "size_type_id" => $hipType->id, "min" => 16, "max" => 18
            ],
            
            [
                "size_id" => $xxlSize->id, "size_type_id" => $USsizeType->id, "min" => 20, "max" => 22
            ],
            [
                "size_id" => $xxlSize->id, "size_type_id" => $chestType->id, "min" => 46, "max" => 48
            ],
            [
                "size_id" => $xxlSize->id, "size_type_id" => $waistType->id, "min" => 40, "max" => 42
            ],
            [
                "size_id" => $xxlSize->id, "size_type_id" => $hipType->id, "min" => 49, "max" => 51
            ],

            [
                "size_id" => $xxxlSize->id, "size_type_id" => $USsizeType->id, "min" => 52, "max" => 54
            ],
            [
                "size_id" => $xxxlSize->id, "size_type_id" => $chestType->id, "min" => 44, "max" => 46
            ],
            [
                "size_id" => $xxxlSize->id, "size_type_id" => $waistType->id, "min" => 49, "max" => 51
            ],
            [
                "size_id" => $xxxlSize->id, "size_type_id" => $hipType->id, "min" => 24, "max" => 26
            ],

            [
                "size_id" => $xxxxlSize->id, "size_type_id" => $USsizeType->id, "min" => 28, "max" => 30
            ],
            [
                "size_id" => $xxxxlSize->id, "size_type_id" => $chestType->id, "min" => 52, "max" => 55
            ],
            [
                "size_id" => $xxxxlSize->id, "size_type_id" => $waistType->id, "min" => 48, "max" => 50
            ],
            [
                "size_id" => $xxxxlSize->id, "size_type_id" => $hipType->id, "min" => 55, "max" => 57
            ],
        ];

        foreach($size_ranges as $row) {
            $sizeRangeObj = new Size_range;
            foreach($row as $col=>$val) {
                $sizeRangeObj->{$col} = $val;
            }
            $sizeRangeObj->save();
        }
    }
}
