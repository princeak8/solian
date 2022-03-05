<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = array(
            "NGN", "USD", "EUR", "GBP"
        );
        $active = array(
            1, 0, 0, 0
        );
        $sign = array(
            '₦', '$', '€', '£'
        );
        foreach($currencies as $key=>$currency) {
            DB::table('currencies')->insert([
                'name' => $currency,
                'active' => $active[$key],
                'sign' => $sign[$key]
            ]);
        }
    }
}
