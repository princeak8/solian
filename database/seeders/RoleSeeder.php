<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = array(
            "super admin", "admin", "customer"
        );
        foreach($roles as $role) {
            DB::table('roles')->insert([
                'role' => $role,
            ]);
        }
    }
}
