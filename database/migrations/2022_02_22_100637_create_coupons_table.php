<?php
/** @noinspection PhpUnused */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('covent_id')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->unsignedBigInteger('count');
            $table->unsignedBigInteger('used')->default('0');
            $table->unsignedBigInteger('user_id')->default('0');
            $table->unsignedBigInteger('referal_user_id')->default('0');
            $table->unsignedBigInteger('percent');
            $table->unsignedBigInteger('value');
            $table->unsignedBigInteger('active')->default('1');
            $table->dateTime('expire_date');
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
        Schema::dropIfExists('coupons');
    }
}
