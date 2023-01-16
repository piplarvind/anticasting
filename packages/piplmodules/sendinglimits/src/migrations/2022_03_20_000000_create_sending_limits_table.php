<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendingLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sending_limits', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->longText('information_needed')->nullable();
            $table->boolean('default')->default(1);
            $table->boolean('status')->default(1);
            $table->smallInteger('order')->nullable();
            $table->timestamps();
        });

        Schema::create('sending_limit_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sending_limit_id')->unsigned()->index()->nullable();
            $table->foreign('sending_limit_id')->references('id')->on('sending_limits')->onDelete('cascade');
            $table->float('one_day_price', 8, 2)->nullable();
            $table->float('thirty_day_price', 8, 2)->nullable();
            $table->float('half_yearly_price', 8, 2)->nullable();
            $table->longText('information_needed')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('sending_limit_attributes');
        Schema::dropIfExists('sending_limits');
    }
}
