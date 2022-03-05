<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Lilian Enwerem",
            'email' => "lilian@gmail.com",
            'password' => bcrypt("lilian123"),
            'role_id' => 2,
            'phone_number' => "08183964260",
        ]);

        DB::table('users')->insert([
            'name' => "Mike Igwe",
            'email' => "mike@gmail.com",
            'password' => bcrypt("mike123"),
            'role_id' => 2,
            'phone_number' => "08163974264",
        ]);
    }
}
