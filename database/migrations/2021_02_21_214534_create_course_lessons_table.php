<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_lessons', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id');
            $table->integer('course_id');
            $table->unsignedBigInteger('section_id');
            $table->string('lesson_title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('content_type')->nullable()->comment('pdf,doc,video,audio');
            $table->string('content')->nullable();
            $table->string('content_link')->nullable();
            $table->string('video_provider',15)->nullable()->comment('local,youtube');
            $table->string('duration', 55)->nullable();
            $table->integer('free_lesson')->nullable();
            $table->integer('position')->default(0);
            $table->tinyInteger('approved')->default(1);
            $table->string('status', 10)->default('active');
            $table->integer('updated_by')->nullable();
            $table->integer('created_by')->nullable();
            $table->foreign('section_id')->references('id')->on('course_sections')->onDelete('cascade');
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
        Schema::dropIfExists('course_lessons');
    }
}
