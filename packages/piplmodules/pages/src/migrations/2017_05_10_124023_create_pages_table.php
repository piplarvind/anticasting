<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by')->unsigned()->index()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->unsigned()->index()->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->longText('page_url')->nullable();
            $table->enum('page_type', ['pages','about', 'education','event','career'])->default('pages');
            $table->boolean('active')->default(1);
            $table->boolean('static')->default(0);
            $table->boolean('published')->default(1);
            $table->timestamps();
        });

        Schema::create('pages_trans', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id')->unsigned()->index();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->string('title');
            $table->text('body');
            $table->text('top_image')->nullable();
            $table->text('page_seo_title')->nullable();
            $table->text('page_meta_keywords')->nullable();
            $table->text('page_meta_descriptions')->nullable();
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
        Schema::dropIfExists('pages_trans');
        Schema::dropIfExists('pages');
    }
}
