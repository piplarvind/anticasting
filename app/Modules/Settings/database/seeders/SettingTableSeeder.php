<?php

namespace App\Modules\Settings\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon; 
class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //Id =1 
        DB::table('settings')->insert([
             'name'=>'info',
             'key'=>'site_title',
             'value'=>'Anticasting ',
             'created_at'=> Carbon::now()->format('Y-m-d'),
             'updated_at'=> Carbon::now()->format('Y-m-d'), 
        ]);
        //Id =2
        DB::table('settings')->insert([
            'name'=>'info',
            'key'=>'site_email',
            'value'=>'anticasting@gmail.com',
            'created_at'=> Carbon::now()->format('Y-m-d'),
            'updated_at'=> Carbon::now()->format('Y-m-d'), 
       ]);
        //Id =3
        DB::table('settings')->insert([

            'name'=>'info',
            'key'=>'address',
            'value'=>'Pune India',
            'created_at'=> Carbon::now()->format('Y-m-d'),
            'updated_at'=> Carbon::now()->format('Y-m-d'), 
       ]);
          //Id = 4
          DB::table('settings')->insert([

            'name'=>'info',
            'key'=>'site_url',
            'value'=>'anticasting.in',
            'created_at'=> Carbon::now()->format('Y-m-d'),
            'updated_at'=> Carbon::now()->format('Y-m-d'), 
       ]);
    }
}
