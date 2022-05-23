<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Collection;

class NewArrivalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newArrivals = Collection::where('name', 'new arrivals')->first();
        if(!$newArrivals) {
            $collection = new Collection;
            $collection->name = 'new arrivals';
            $collection->description = "Collection of new Arrivals";
            $collection->save();
        }
    }
}
