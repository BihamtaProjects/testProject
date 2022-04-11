<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('service_plan_id')->index();
            $table->foreign('service_plan_id')->references('id')->on('service_plans')->onDelete('cascade');
            $table->integer('duration');
            $table->integer('freeday');
            $table->integer('price');
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
        Schema::dropIfExists('service_prices');
    }
}
