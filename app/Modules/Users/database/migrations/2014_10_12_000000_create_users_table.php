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
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile_verified')->nullable();
            $table->string('activation_code')->nullable();
            $table->string('countryCode')->nullable();
            $table->string('mobile_no')->nullable();
         
            $table->boolean('status')->default(0)
            ->comment('0=>INACTIVE,1=>ACTIVE');
            $table->string('image')->nullable();
            $table->enum('user_type',['0','1'])->default(0)->
            comment('0=>USER,1=>ADMIN');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
          

            
         
          
        });
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
};
