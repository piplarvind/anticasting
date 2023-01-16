<?php
namespace Piplmodules\Permissions\Seeds;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // #1
        \DB::table('permissions')->insert([
            'slug' => 'settings',
            'active' => 1
        ]);
        \DB::table('permissions_trans')->insert([
            'permission_id' => 1,
            'name' => 'Global Settings',
            'description' => 'Global Settings',
            'lang' => 'en',
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);
        // #2
        \DB::table('permissions')->insert([
            'slug' => 'admin-users',
            'active' => 1
        ]);
        \DB::table('permissions_trans')->insert([
            'permission_id' => 2,
            'name' => 'Manage Admin',
            'description' => 'Manage Admin',
            'lang' => 'en',
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);
        // #3
        \DB::table('permissions')->insert([
            'slug' => 'users',
            'active' => 1
        ]);
        \DB::table('permissions_trans')->insert([
            'permission_id' => 3,
            'name' => 'Manage Users',
            'description' => 'Manage Users',
            'lang' => 'en',
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);
        // #4
        \DB::table('permissions')->insert([
            'slug' => 'roles',
            'active' => 1
        ]);
        \DB::table('permissions_trans')->insert([
            'permission_id' => 4,
            'name' => 'Manage Roles',
            'description' => 'Manage Roles',
            'lang' => 'en',
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);
        // #5
        \DB::table('permissions')->insert([
            'slug' => 'emailtemplates',
            'active' => 1
        ]);
        \DB::table('permissions_trans')->insert([
            'permission_id' => 5,
            'name' => 'Manage Email Templates',
            'description' => 'Manage Email Templates',
            'lang' => 'en',
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);
        // #6
        \DB::table('permissions')->insert([
            'slug' => 'essay-topics',
            'active' => 1
        ]);
        \DB::table('permissions_trans')->insert([
            'permission_id' => 6,
            'name' => 'Manage Essay Topics',
            'description' => 'Manage Essay Topics',
            'lang' => 'en',
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);
        // #7
        \DB::table('permissions')->insert([
            'slug' => 'pages',
            'active' => 1
        ]);
        \DB::table('permissions_trans')->insert([
            'permission_id' => 7,
            'name' => 'Manage CMS Pages',
            'description' => 'Manage CMS Pages',
            'lang' => 'en',
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);
        // #8
        \DB::table('permissions')->insert([
            'slug' => 'banners',
            'active' => 1
        ]);
        \DB::table('permissions_trans')->insert([
            'permission_id' => 8,
            'name' => 'Manage Gallery',
            'description' => 'Manage Gallery',
            'lang' => 'en',
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);
        // #9
        \DB::table('permissions')->insert([
            'slug' => 'banners',
            'active' => 1
        ]);
        \DB::table('permissions_trans')->insert([
            'permission_id' => 9,
            'name' => 'Manage Banners',
            'description' => 'Manage Banners',
            'lang' => 'en',
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);
        // #10
        \DB::table('permissions')->insert([
            'slug' => 'contact-us',
            'active' => 1
        ]);
        \DB::table('permissions_trans')->insert([
            'permission_id' => 10,
            'name' => 'Manage Contact Us',
            'description' => 'Manage Contact Us',
            'lang' => 'en',
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);
        // #11
        \DB::table('permissions')->insert([
            'slug' => 'essay-list',
            'active' => 1
        ]);
        \DB::table('permissions_trans')->insert([
            'permission_id' => 11,
            'name' => 'Manage Essay Listing',
            'description' => 'Manage Essay Listing',
            'lang' => 'en',
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);
        // #12
        \DB::table('permissions')->insert([
            'slug' => 'essay-assignment',
            'active' => 1
        ]);
        \DB::table('permissions_trans')->insert([
            'permission_id' => 12,
            'name' => 'Manage Essay Assignment',
            'description' => 'Manage Essay Assignment',
            'lang' => 'en',
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);
        // #13
        \DB::table('permissions')->insert([
            'slug' => 'essay-feedbacks',
            'active' => 1
        ]);
        \DB::table('permissions_trans')->insert([
            'permission_id' => 13,
            'name' => 'Essay Feedbacks',
            'description' => 'Essay Feedbacks',
            'lang' => 'en',
            'created_at' => Carbon::now()->format('Y-m-d'),
            'updated_at' => Carbon::now()->format('Y-m-d'),
        ]);

    }
}
