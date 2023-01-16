<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Piplmodules\Settings\Seeds\SettingsTableSeeder;
use Piplmodules\Permissions\Seeds\PermissionsTableSeeder;
use Piplmodules\Roles\Seeds\RolesTableSeeder;
use Piplmodules\Users\Seeds\UsersTableSeeder;
use Piplmodules\Emailtemplates\Seeds\EmailTemplatesTableSeeder;
use Piplmodules\Pages\Seeds\PagesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(SettingsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(EmailtemplatesTableSeeder::class);

        //dd("Please uncomment, before proceeding");
    }
}
