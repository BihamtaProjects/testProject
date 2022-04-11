<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoventsessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coventsessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('covent_id')->index();
            $table->foreign('covent_id')->references('id')->on('covents')->onDelete('cascade');
            $table->unsignedBigInteger('unit_id')->index();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->unsignedBigInteger('duration');
            $table->unsignedBigInteger('video_length')->default('0');
            $table->dateTime('start_time');
            $table->unsignedBigInteger('priority')->default('0');
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
        Schema::dropIfExists('coventsessions');
    }
}
