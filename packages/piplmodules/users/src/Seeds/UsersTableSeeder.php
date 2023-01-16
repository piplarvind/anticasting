<?php
namespace Piplmodules\Users\Seeds;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Super ِAdmin
        \DB::table('users')->insert([
            'name' => 'Admin',
            'first_name' => 'Supper',
            'last_name' => 'Admin',
            'email' => 'admin@payzz.com',
            'country_code' => '91',
            'mobile_number' => '1234567890',
            'password' => bcrypt('admin@2021'),
            'user_type' => '1',
            'email_verified'=> 1,
            'account_status'=> '1',
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);
        \DB::table('user_informations')->insert([
            'user_id' => 100001,
            'referral_code' => rand(),
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);
        \DB::table('users_roles')->insert([
            'role_id' => 1,
            'user_id'=> 100001
        ]);


        //Sub ِAdmin
        \DB::table('users')->insert([
            'name' => 'Sub Admin',
            'first_name' => 'Sub',
            'last_name' => 'Admin',
            'email' => 'subadmin@payzz.com',
            'country_code' => '91',
            'mobile_number' => '1234567890',
            'password' => bcrypt('Z5MZIAW!1vbo2'),
            'user_type' => '1',
            'email_verified'=> 1,
            'account_status'=> '1',
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);
        \DB::table('user_informations')->insert([
            'user_id' => 100002,
            'referral_code' => rand(),
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);
        \DB::table('users_roles')->insert([
            'role_id' => 2,
            'user_id'=> 100002
        ]);
    }
}
