<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_group_id')->index();
            $table->foreign('service_group_id')->references('id')->on('service_groups')->onDelete('cascade');
            $table->string('name');
            $table->integer('userlimit');
            $table->integer('duration');
            $table->integer('videolimit');
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
        Schema::dropIfExists('service_plans');
    }
}
