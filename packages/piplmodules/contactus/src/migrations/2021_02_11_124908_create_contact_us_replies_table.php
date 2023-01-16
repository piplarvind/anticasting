<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us_replies', function (Blueprint $table) {
            $table->id();
            $table->integer('contact_id')->nullable();
            $table->boolean('is_read')->default(0)
                ->comment('0=> Unread, 1=> Read');
            $table->longText('reply_msg')->nullable();
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
        Schema::dropIfExists('contact_us_replies');
    }
}
