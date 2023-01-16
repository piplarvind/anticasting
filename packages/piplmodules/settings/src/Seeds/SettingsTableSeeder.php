<?php

namespace Piplmodules\Settings\Seeds;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Main Information (1-5)
		\DB::table('settings')->insert([
            'name' => 'info',
            'key' => 'site_title',
            'value' => 'PAYzz'
        ]);
        \DB::table('settings')->insert([
            'name' => 'info',
            'key' => 'site_email',
            'value' => 'info@payzz.com'
        ]);
        \DB::table('settings')->insert([
            'name' => 'info',
            'key' => 'phone',
            'value' => '+1 6464203532'
        ]);
        \DB::table('settings')->insert([
            'name' => 'info',
            'key' => 'address',
            'value' => 'New York, US'
        ]);

        \DB::table('settings')->insert([
            'name' => 'info',
            'key' => 'contact_email',
            'value' => 'contact@payzz.com'
        ]);

        \DB::table('settings')->insert([
            'name' => 'info',
            'key' => 'fees',
            'value' => '3.99'
        ]);

        \DB::table('settings')->insert([
            'name' => 'info',
            'key' => 'google_paly',
            'value' => 'https://play.google.com'
        ]);

        \DB::table('settings')->insert([
            'name' => 'info',
            'key' => 'apple_store',
            'value' => 'https://www.apple.com/store'
        ]);
    }
}
