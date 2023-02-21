<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->longText('msg')->nullable();
            $table->boolean('status')->default(0)->comment('0=>Inactive,1=>Active');
            $table->timestamps();
        });
        Schema::create('message_reply', function (Blueprint $table) {
            $table->id();
            $table->longText('reply_msg')->nullable();
            $table->unsignedBigInteger('msg_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('msg_id')->references('id')->on('messages')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('messages');
        Schema::dropIfExists('reply_msg');
    }
};
