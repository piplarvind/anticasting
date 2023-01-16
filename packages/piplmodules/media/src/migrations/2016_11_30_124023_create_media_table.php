<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('caption')->nullable();
            $table->string('alt')->nullable();
            $table->text('description')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('extension')->nullable();
            $table->string('filename')->nullable();
            $table->string('file_size')->nullable();
            $table->string('height')->nullable();
            $table->string('width')->nullable();
            $table->string('type')->nullable();
            $table->string('subtype')->nullable();
            $table->string('file')->nullable();
            $table->text('options')->nullable();//json
            $table->integer('uploaded_by')->nullable();
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
        Schema::dropIfExists('media');
    }
}
