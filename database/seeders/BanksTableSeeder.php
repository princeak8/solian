<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = array(
            "Guarantee Trust Bank (GTB)", "Firstbank Nig Plc", "Zenith Bank", "United Bank for Africa (UBA)", "Union Bank", "Acess Bank", "Fidelity Bank", 
            "Stanbic IBTC Bank", "Union Bank", "Sterling Bank", "First City Monument Bank (FCMB)", "Citibank", "Dynamic Standard Bank", "Ecobank Nigeria", 
            "Heritage Bank Plc", "Jaiz Bank", "Keystone Bank Limited", "Providus Bank Plc", "Polaris Bank", "Standard Chartered Bank", "Suntrust Bank Nigeria Limited", 
            "Unity Bank Plc", "Wema Bank"
        );
        foreach($banks as $bank) {
            DB::table('banks')->insert([
                'name' => $bank,
            ]);
        }
    }
}
