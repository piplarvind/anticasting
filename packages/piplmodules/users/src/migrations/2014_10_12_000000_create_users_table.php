<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('country_code', 10)->nullable();
            $table->string('mobile_number')->nullable();
            $table->enum('account_status', ['0', '1', '2', '3'])
                ->default('0')
                ->comment('0=> Inactive 1=> Active, 2=>Blocked, 3=>Suspended');
            /*$table->enum('user_status', ['0', '1', '2', '3'])
                ->default('0')
                ->comment('0=> Inactive 1=> Active, 2=>Blocked, 3=>Suspended');*/
            $table->boolean('email_verified')->default(0)
                ->comment('0=> Not Verified, 1=>Verified');
            $table->boolean('mobile_verified')->default(0)
                ->comment('0=> Not Verified, 1=>Verified');
            $table->enum('user_type', ['1', '2', '3'])
                ->default('2')
                ->comment('1=> Admin, 2=> User, 3=> Sponsor');
            $table->enum('gender', ['1', '2', '3'])
                ->default('1')
                ->comment('1=> Male, 2=>Female, 3=>Masculine');
            $table->string('activation_code')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->text('profile_photo_path')->nullable();
            $table->timestamps();
        });

        //then set autoincrement to 10000
        //after creating the table
        DB::update("ALTER TABLE users AUTO_INCREMENT = 10000;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
