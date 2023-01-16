<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by')->unsigned()->index()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->unsigned()->index()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('active');
            $table->integer('order_id')->nullable();
            $table->timestamps();
        });

        Schema::create('banners_trans', function(Blueprint $table)
        {
            $table->id();
            $table->unsignedBigInteger('banner_id')->unsigned()->index()->nullable();
            $table->foreign('banner_id')->references('id')->on('banners')->onDelete('cascade');
            $table->string('banner_img')->nullable();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->string('location')->nullable();
            $table->text('url')->nullable();
            $table->string('lang');
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
        Schema::dropIfExists('banners_trans');
        Schema::dropIfExists('banners');
    }
}
