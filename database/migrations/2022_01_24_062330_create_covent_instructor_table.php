<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoventInstructorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covent_instructor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('covent_id')->index();
            $table->foreign('covent_id')->references('id')->on('covents')->onDelete('cascade');
            $table->unsignedBigInteger('instructor_id')->index();
            $table->foreign('instructor_id')->references('id')->on('instructors')->onDelete('cascade');
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
        Schema::dropIfExists('covent_instructor');
    }
}
