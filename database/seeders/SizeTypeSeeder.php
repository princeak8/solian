<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

use App\Models\Size_type;

class SizeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = array(
            "US SIZE", "CHEST", "WAIST", "HIP"
        );
        foreach($types as $type) {
            /*
            DB::table('ranges')->insert([
                'range' => $range,
            ]);
            */
            Size_type::firstOrCreate(['type' => $type]);
        }
    }
}
