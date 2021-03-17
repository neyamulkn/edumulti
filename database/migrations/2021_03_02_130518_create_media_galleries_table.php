<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('source_path', 125)->nullable();
            $table->string('video_link', 255)->nullable();
            $table->string('video_provider', 255)->nullable()->comment('local,youtube, vimeo');
            $table->string('type', 10)->comment('image,video,audio,pdf');
            $table->tinyInteger('use_time')->default(1);
            $table->integer('user_id');
            $table->tinyInteger('status');
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
        Schema::dropIfExists('media_galleries');
    }
}
