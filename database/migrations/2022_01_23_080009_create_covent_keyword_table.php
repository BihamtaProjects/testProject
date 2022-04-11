<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoventKeywordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covent_keyword', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('covent_id')->index();
            $table->foreign('covent_id')->references('id')->on('covents')->onDelete('cascade');
            $table->unsignedBigInteger('keyword_id')->index();
            $table->foreign('keyword_id')->references('id')->on('keywords')->onDelete('cascade');
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
        Schema::dropIfExists('covent_keyword');
    }
}
