<?php

namespace App\Modules\Users\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DateTime;
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
        //
     
        // Id = 1 
        \DB::table('users')->insert([

            'name'=>'Admin',
            'first_name'=>'Super',
            'last_name'=>'Admin',
            'email'=>'admin@gmail.com',
            'password'=> bcrypt('Admin@10'),
           
          //  'gender	'=>'Male',
            'status'=>1,
            'user_type'=>'1',
            'mobile_no'=>'9661234878',
            'created_at'=> Carbon::now()->format('Y-m-d'),
            'updated_at'=> Carbon::now()->format('Y-m-d'),
        ]);

         // Id = 2 
         \DB::table('users')->insert([

            'name'=>'Sub Admin',
            'first_name'=>'Sub',
            'last_name'=>'Admin',
            'email'=>'admin@2023gmail.com',
            'password'=> bcrypt('Admin@10'),
          
           // 'gender	'=>'Female',
            'status'=>1,
            'user_type'=>'1',
            'mobile_no'=>'9762137636',
            'created_at'=> Carbon::now()->format('Y-m-d'),
            'updated_at'=> Carbon::now()->format('Y-m-d'),
        ]);
         // Id = 3 
         \DB::table('users')->insert([

            'name'=>'mahesh kumar singh',
            'first_name'=>'Mahesh',
            'last_name'=>'Kumar Singh',
            'email'=>'maheshkrs@2023gmail.com',
            'password'=> bcrypt('Pass@123'),
          
           // 'gender	'=>'Male',
            'status'=>1,
            'user_type'=>'0',
            'mobile_no'=>'9404520736',
            'created_at'=> Carbon::now()->format('Y-m-d'),
            'updated_at'=> Carbon::now()->format('Y-m-d'),
        ]);
    }
}
