<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->nullable()->unsigned();
            $table->uuid('uid');
            $table->string('title');
            $table->boolean('active')->default(false);
            $table->float('price')->default(0);
            $table->integer('partisipant_start_number')->default(1);
            $table->integer('age_from')->default(0);
            $table->integer('age_to')->default(0);
            $table->integer('participants_limit')->default(0);
            $table->longText('additional_conditions')->nullable();
            $table->timestamps();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laps');
    }
}
