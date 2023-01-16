<?php
namespace Piplmodules\Roles\Seeds;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin Role 1
        \DB::table('roles')->insert([
            'id' => 1,
        ]);
        \DB::table('roles_trans')->insert([
            'role_id' => 1,
            'name' => 'Admin',
            'lang' => 'en',
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);
        // End Admin Role

        // SubAdmin Role 2
        \DB::table('roles')->insert([
            'id' => 2,
        ]);
        \DB::table('roles_trans')->insert([
            'role_id' => 2,
            'name' => 'Sub Admin',
            'lang' => 'en',
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);

        // Registered User Role 3
        \DB::table('roles')->insert([
            'id' => 3,
        ]);

        \DB::table('roles_trans')->insert([
            'role_id' => 3,
            'name' => 'Users',
            'lang' => 'en',
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);
        // End Registered User Role
    }
}
