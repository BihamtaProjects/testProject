<?php
/** @noinspection PhpUnused */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('summary')->nullable();
            $table->text('description')->nullable();
            $table->text('prerequirement')->nullable();
            $table->unsignedBigInteger('duration');
            $table->unsignedBigInteger('unit_id')->index();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->unsignedBigInteger('type_id')->index();
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->unsignedBigInteger('organizer_id')->index();
            $table->foreign('organizer_id')->references('id')->on('organizers')->onDelete('cascade');
            $table->unsignedBigInteger('video_length')->default('0');
            $table->dateTime('start_time');
            $table->string('main_pic')->nullable();
            $table->string('main_video')->nullable();
            $table->unsignedBigInteger('is_event')->default('0');
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
        Schema::dropIfExists('covents');
    }
}
