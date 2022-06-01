<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Currency;
use DB;

class CurrencyRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = Currency::all();
        $currencyRates = [];
        foreach($currencies as $currency) {
            $currencyRates[] = ['currency_id'=>$currency->id];
        }

        foreach($currencyRates as $rate) {
            DB::table('currency_rate')->insert([
                'currency_id' => $rate['currency_id'],
                'rate' => 1
            ]);
        }
    }
}
