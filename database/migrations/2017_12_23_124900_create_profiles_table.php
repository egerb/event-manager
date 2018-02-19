<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uid');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('birth_date');
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('city')->nullable();
            $table->string('contacts_data')->nullable();
            $table->string('team')->nullable();
            $table->string('club')->nullable();
            $table->enum('t_shirt_size', [
                'S', 'M', 'L', 'XS', 'XL', 'XXL', 'XXXL'
            ])->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
