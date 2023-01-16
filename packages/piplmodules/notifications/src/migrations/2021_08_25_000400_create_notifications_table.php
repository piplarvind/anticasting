<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // notification table
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('from_id')->unsigned()->index()->nullable();
            // $table->foreign('from_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('to_id')->unsigned()->index()->nullable();
            // $table->foreign('to_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('transaction_id')->unsigned()->index()->nullable();
            // $table->foreign('transaction_id')->references('id')->on('user_payment_details')->onDelete('cascade');

            $table->string('subject')->nullable();
            $table->text('description')->nullable();

            $table->boolean('status')
                ->default(0)
                ->comment('0=> Unread 1=> Read');

            $table->dateTime('expired_at')->nullable();

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
        Schema::dropIfExists('notifications');
    }
}
