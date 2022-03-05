<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

use App\Models\Order_status;

class OrderStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = array(
            "pending", "completed", "conflict"
        );
        foreach($statuses as $status) {
            /*DB::table('order_statuses')->insert([
                'status' => $status,
            ]);*/
            Order_status::firstOrCreate(['status' => $status]);
        }
    }
}
