<?php

namespace Piplmodules\Pages\Seeds;

use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //#1
        \DB::table('pages')->insert([
            'created_by' => '1',
            'page_url' => 'terms-conditions',
            'page_type' => 'pages',
            'static' => 1
        ]);
        
        \DB::table('pages_trans')->insert([
            'page_id' => 1,
            'title' => 'Terms & Conditions',
            'body' => 'Terms & Conditions',
            'lang' => 'en'
        ]);

        //#2
        \DB::table('pages')->insert([
            'created_by' => '1',
            'page_url' => 'privacy-policy',
            'page_type' => 'pages',
            'static' => 1
        ]);
        //trans
        \DB::table('pages_trans')->insert([
            'page_id' => 2,
            'title' => 'Privacy Policy',
            'body' => 'Privacy Policy',
            'lang' => 'en'
        ]);

        //#3
        \DB::table('pages')->insert([
            'created_by' => '1',
            'page_url' => 'about-us',
            'page_type' => 'pages',
            'static' => 1
        ]);
        //trans
        \DB::table('pages_trans')->insert([
            'page_id' => 3,
            'title' => 'About Us',
            'body' => 'About Us',
            'lang' => 'en'
        ]);

        //#4
        \DB::table('pages')->insert([
            'created_by' => '1',
            'page_url' => 'manage-cookies',
            'page_type' => 'pages',
            'static' => 1
        ]);
        //trans
        \DB::table('pages_trans')->insert([
            'page_id' => 4,
            'title' => 'Manage Cookies',
            'body' => 'Manage Cookies',
            'lang' => 'en'
        ]);

        //#5
        \DB::table('pages')->insert([
            'created_by' => '1',
            'page_url' => 'how-it-works',
            'page_type' => 'pages',
            'static' => 1
        ]);
        //trans
        \DB::table('pages_trans')->insert([
            'page_id' => 5,
            'title' => 'How It Works',
            'body' => 'How It Works',
            'lang' => 'en'
        ]);

        //#6
        \DB::table('pages')->insert([
            'created_by' => '1',
            'page_url' => 'global-home',
            'page_type' => 'pages',
            'static' => 1
        ]);
        //trans
        \DB::table('pages_trans')->insert([
            'page_id' => 6,
            'title' => 'Global Home',
            'body' => 'Global Home',
            'lang' => 'en'
        ]);

        //#7
        \DB::table('pages')->insert([
            'created_by' => '1',
            'page_url' => 'send-money-safely',
            'page_type' => 'pages',
            'static' => 1
        ]);
        //trans
        \DB::table('pages_trans')->insert([
            'page_id' => 7,
            'title' => 'Send Money Safely',
            'body' => 'Send Money Safely',
            'lang' => 'en'
        ]);


    }
}
