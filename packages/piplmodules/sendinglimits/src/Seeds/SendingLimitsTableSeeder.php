<?php
namespace Piplmodules\Sendinglimits\Seeds;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SendinglimitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \DB::table('sending_limits')->insert([
            'name' => 'Tier 1',
            // 'one_day' => '24 Hours',
            'one_day_price' => 2999,
            // 'thirty_day' => '30 Days',
            'thirty_day_price' => 10000,
            // 'half_yearly' => '180 Days',
            'half_yearly_price' => 18000,
            'information_needed' => 'Your full name

            Your residential address
            
            Your date of birth
            
            The last 4 digits of your SSN',
            'status' => 1,
            'order' => 1,
            'created_at' => Carbon::now()
        ]);

        \DB::table('sending_limits')->insert([
            'name' => 'Tier 2',
            // 'one_day' => '24 Hours',
            'one_day_price' => 6000,
            // 'thirty_day' => '30 Days',
            'thirty_day_price' => 20000,
            // 'half_yearly' => '180 Days',
            'half_yearly_price' => 36000,
            'information_needed' => 'Tier 1 information if not already approved

            Your full SSN/ITIN
            
            Your government issued photo ID
            
            Additional information about your use of our service including details of your source of funds',
            'status' => 1,
            'order' => 1,
            'created_at' => Carbon::now()
        ]);

        \DB::table('sending_limits')->insert([
            'name' => 'Tier 2',
            // 'one_day' => '24 Hours',
            'one_day_price' => 10000,
            // 'thirty_day' => '30 Days',
            'thirty_day_price' => 30000,
            // 'half_yearly' => '180 Days',
            'half_yearly_price' => 60000,
            'information_needed' => 'Tier 2 information if not already approved

            Additional information on your use of our service',
            'status' => 1,
            'order' => 1,
            'created_at' => Carbon::now()
        ]);


    }
}
