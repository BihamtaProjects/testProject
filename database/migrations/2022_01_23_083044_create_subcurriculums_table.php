<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcurriculumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcurriculums', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curriculum_id')->index();
            $table->foreign('curriculum_id')->references('id')->on('curriculums')->onDelete('cascade');
            $table->string('title');
            $table->text('summary');
            $table->text('description')->nullable();
            $table->string('video_preview')->nullable();
            $table->unsignedBigInteger('video_length')->nullable();
            $table->unsignedInteger('active')->default('1');
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
        Schema::dropIfExists('subcurriculums');
    }
}
