<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uid');
            $table->integer('lap_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->enum('payment', ['BY_LIQPAY', 'BY_MANUAL', 'NO_PAYMENT'])->default('NO_PAYMENT');
            $table->string('tracker_id')->nullable();
            $table->text('additional_info')->nullable();
            $table->text('additional_distance')->nullable();

            $table->foreign('lap_id')->references('id')->on('laps')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('participants');
    }
}
