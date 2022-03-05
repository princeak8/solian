<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

use App\Models\Payment_status;

class PaymentStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = array(
            "unpaid", "paid", "deposit"
        );
        foreach($statuses as $status) {
            Payment_status::firstOrCreate(['status' => $status]);
        }
    }
}
