<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubscriptionAttrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscription_attrs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');          
            $table->integer('user_subscription_id');  
            $table->string('one_day')->nullable();
            $table->integer('one_day_price')->nullable();
            $table->string('thirty_day')->nullable();
            $table->integer('thirty_day_price')->nullable();
            $table->string('half_yearly')->nullable();
            $table->integer('half_yearly_price')->nullable();
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
        Schema::dropIfExists('user_subscription_attrs');
    }
}
