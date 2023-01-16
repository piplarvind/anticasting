<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendingCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sending_countries', function (Blueprint $table) {
            $table->id();
            $table->string('country_name', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('payment_methods', 100)->nullable();
            $table->enum('status',['1','0'])->default(1)->comment("1=>Active, 0=>Inactive");
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
        Schema::dropIfExists('sending_countries');
    }
}
