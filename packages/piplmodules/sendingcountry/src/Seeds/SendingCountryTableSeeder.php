<?php
namespace Piplmodules\SendingCountry\Seeds;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SendingCountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //1st
        \DB::table('sending_countries')->insert([
            'country_name' =>'United States',
            'slug' =>'united-states',
            'flag'=>'usa.png',
            'payment_methods'=>"1",
            'status' => 1,
            'created_at' => Carbon::now()
        ]);


    }
}
