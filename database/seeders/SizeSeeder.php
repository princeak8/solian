<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

use App\Models\Size;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = array(
            "XS", "S", "M", "L", "XL", "XXL", "XXXL", "XXXXL"
        );
        foreach($sizes as $size) {
            /*
            DB::table('ranges')->insert([
                'range' => $range,
            ]);
            */
            Size::firstOrCreate(['size' => $size]);
        }
    }
}
