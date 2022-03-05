<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company')->insert([
            'name' => "Solian Collections",
            'email' => "solianCollections@gmail.com",
            'phone_numbers' => "+234 818 396 4260",
            'address' => "5 Usman Sarki Crescent Utako, off Big Joe Transport Company",
            'about' => "Solian Collections is a unique fashion house that delivers excellent products",
    ]);
    }
}
