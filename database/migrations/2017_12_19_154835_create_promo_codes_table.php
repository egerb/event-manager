<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uid');
            $table->integer('lap_id')->unsigned()->nullable();
            $table->string('promo_code');
            $table->integer('discount_percent')->default(1);
            $table->boolean('used')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('lap_id')->references('id')->on('laps')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promo_codes');
    }
}
