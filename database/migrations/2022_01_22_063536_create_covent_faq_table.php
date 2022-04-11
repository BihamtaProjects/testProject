<?php
/** @noinspection PhpUnused */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoventFaqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covent_faq', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('covent_id')->index();
            $table->foreign('covent_id')->references('id')->on('covents')->onDelete('cascade');
            $table->unsignedBigInteger('faq_id')->index();
            $table->foreign('faq_id')->references('id')->on('faqs')->onDelete('cascade');
            $table->unsignedInteger('priority')->default('0');
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
        Schema::dropIfExists('covent_faq');
    }
}
