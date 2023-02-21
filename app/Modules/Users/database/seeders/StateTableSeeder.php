<?php

namespace App\Modules\Users\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateTableSeeder extends Seeder
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
         \DB::table('states')->insert([

            'name'=>'Andhra Pradesh',
            'value'=>'Andhra Pradesh',
            'state_no'=>1,
        ]);
       // Id = 2 
        \DB::table('states')->insert([

            'name'=>'Arunachal Pradesh',
            'value'=>'Arunachal Pradesh',
            'state_no'=>2,
        ]);
         // Id = 3 
        \DB::table('states')->insert([

            'name'=>'Assam',
            'value'=>'Assam',
            'state_no'=>3,
        ]);
         // Id = 4 
        \DB::table('states')->insert([

            'name'=>'Bihar',
            'value'=>'Bihar',
            'state_no'=>4,
        ]);
         // Id = 5 
        \DB::table('states')->insert([

            'name'=>'Chhattisgarh',
            'value'=>'Chhattisgarh',
            'state_no'=>5,
        ]);
         // Id = 6 
        \DB::table('states')->insert([

            'name'=>'Delhi',
            'value'=>'Delhi',
            'state_no'=>6,
        ]);

          // Id = 7 
          \DB::table('states')->insert([

            'name'=>'Goa',
            'value'=>'Goa',
            'state_no'=>7,
        ]);

          // Id = 8 
          \DB::table('states')->insert([

            'name'=>'Gujarat',
            'value'=>'Gujarat',
            'state_no'=>8,
        ]);
          // Id = 9 
          \DB::table('states')->insert([

            'name'=>'Haryana',
            'value'=>'Haryana',
            'state_no'=>9,
        ]);
          // Id = 10 
          \DB::table('states')->insert([

            'name'=>'Himachal Pradesh',
            'value'=>'Himachal Pradesh',
            'state_no'=>10,
        ]);
          // Id = 11 
          \DB::table('states')->insert([

            'name'=>'Jammu & Kashmir',
            'value'=>'Jammu & Kashmir',
            'state_no'=>11,
        ]);
          // Id = 12 
          \DB::table('states')->insert([

            'name'=>'Jharkhand',
            'value'=>'Jharkhand',
            'state_no'=>12,
        ]);
          // Id = 13 
          \DB::table('states')->insert([

            'name'=>'Karnataka',
            'value'=>'Karnataka',
            'state_no'=>13,
        ]);

        // Id = 14 
        \DB::table('states')->insert([

            'name'=>'Kerala',
            'value'=>'Kerala',
            'state_no'=>14,
        ]);

        // Id = 15 
        \DB::table('states')->insert([

            'name'=>'Maharashtra',
            'value'=>'Maharashtra',
            'state_no'=>15,
        ]);
        // Id = 16 
        \DB::table('states')->insert([

            'name'=>'Madhya Pradesh',
            'value'=>'Madhya Pradesh',
            'state_no'=>16,
        ]);
        // Id = 17 
        \DB::table('states')->insert([

            'name'=>'Manipur',
            'value'=>'Manipur',
            'state_no'=>17,
        ]);
        // Id = 18 
        \DB::table('states')->insert([

            'name'=>'Meghalaya',
            'value'=>'Meghalaya',
            'state_no'=>18,
        ]);
        // Id = 19 
        \DB::table('states')->insert([

            'name'=>'Mizoram',
            'value'=>'Mizoram',
            'state_no'=>19,
        ]);
        // Id = 20 
        \DB::table('states')->insert([

            'name'=>'Nagaland',
            'value'=>'Nagaland',
            'state_no'=>20,
        ]);
        // Id = 21 
        \DB::table('states')->insert([

            'name'=>'Odisha',
            'value'=>'Odisha',
            'state_no'=>21,
        ]);
        // Id = 22 
        \DB::table('states')->insert([

            'name'=>'Punjab',
            'value'=>'Punjab',
            'state_no'=>22,
        ]);
         // Id = 23 
         \DB::table('states')->insert([

            'name'=>'Rajasthan',
            'value'=>'Rajasthan',
            'state_no'=>23,
        ]);
         // Id = 24
         \DB::table('states')->insert([

            'name'=>'Sikkim',
            'value'=>'Sikkim',
            'state_no'=>24,
        ]);
         // Id = 25 
         \DB::table('states')->insert([

            'name'=>'Tamil Nadu',
            'value'=>'Tamil Nadu',
            'state_no'=>25,
        ]);
         // Id = 26 
         \DB::table('states')->insert([
            'name'=>'Tripura',
            'value'=>'Tripura',
            'state_no'=>26,
        ]);
         // Id = 27 
         \DB::table('states')->insert([
            'name'=>'Telangana',
            'value'=>'Telangana',
            'state_no'=>27,
        ]);
         // Id = 28 
         \DB::table('states')->insert([
            'name'=>'Uttar Pradesh',
            'value'=>'Uttar Pradesh',
            'state_no'=>28,
        ]);
         // Id = 29 
         \DB::table('states')->insert([
            'name'=>'Uttarakhand',
            'value'=>'Uttarakhand',
            'state_no'=>29,
        ]);
         // Id = 30 
         \DB::table('states')->insert([
            'name'=>'West Bengal',
            'value'=>'West Bengal',
            'state_no'=>30,
        ]);
        // Id = 31 
        \DB::table('states')->insert([
            'name'=>'Andaman & Nicobar',
            'value'=>'Andaman & Nicobar',
            'state_no'=>31,
        ]);
        // Id = 32 
        \DB::table('states')->insert([
            'name'=>'Chandigarh (UT)',
            'value'=>'Chandigarh (UT)',
            'state_no'=>32,
        ]);
        // Id = 33 
        \DB::table('states')->insert([
            'name'=>'Dadra & Nagar Haveli',
            'value'=>'Dadra & Nagar Haveli',
            'state_no'=>33,
        ]);
        // Id = 34
        \DB::table('states')->insert([
            'name'=>'Daman & Diu',
            'value'=>'Daman & Diu',
            'state_no'=>34,
        ]);
        // Id = 35 
        \DB::table('states')->insert([
            'name'=>'Lakshadweep',
            'value'=>'Lakshadweep',
            'state_no'=>35,
        ]);
        // Id = 36
        \DB::table('states')->insert([
            'name'=>'Puducherry',
            'value'=>'Puducherry',
            'state_no'=>36,
        ]);
    }
}
