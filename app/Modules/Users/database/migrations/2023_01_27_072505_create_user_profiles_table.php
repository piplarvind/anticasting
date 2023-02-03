<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ethnicity')->nullable();
            $table->string('email')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('countryCode')->nullable();
            $table->string('mobile_no')->nullable();
            $table->text('current_location')->nullable();

            $table->string('choose_language')->nullable();
           
            $table->string('intro_video_link')->nullable();
            $table->string('work_reel1')->nullable();
            $table->string('work_reel2')->nullable();
            $table->string('work_reel3')->nullable();

            $table
                ->boolean('status')
                ->default(0)
                ->comment('Active=>1,Inactive=>0');
            $table
                ->unsignedBigInteger('user_id')
                ->unsigned()
                ->index()
                ->nullable();
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table
                ->unsignedBigInteger('user_profile_image_id')
                ->unsigned()
                ->index()
                ->nullable();
            $table
                ->foreign('user_profile_image_id')
                ->references('id')
                ->on('user_profiles_image')
                ->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('user_profiles_image', function (Blueprint $table) {
            $table->id();
            $table->string('profile_images')->nullable();
            $table
                ->unsignedBigInteger('user_id')
                ->unsigned()
                ->index()
                ->nullable();
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
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
        Schema::dropIfExists('user_profiles');
        Schema::dropIfExists('user_profiles_image');
    }
}
