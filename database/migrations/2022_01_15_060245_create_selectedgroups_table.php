<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSelectedgroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('selectedgroups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('page_name');
            $table->integer('type');
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
        Schema::dropIfExists('selectedgroups');
    }
}
