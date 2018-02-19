<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uid')->unique();
            $table->string('title');
            $table->string('date');
            $table->string('place');
            $table->string('slug');
            $table->boolean('main_page')->default(false);

            $table->string('contacts')->nullable();
            $table->longText('letter_agreement')->nullable();
            $table->longText('additional_info')->nullable();
            $table->boolean('active')->default(0);

            $table->string('email')->nullable();
            $table->string('email_from')->nullable();
            $table->string('email_subject')->nullable();
            $table->longText('email_text')->nullable();

            $table->string('email_subject_success_payment')->nullable();
            $table->longText('email_text_success_payment')->nullable();

            $table->string('email_subject_success_payment_admin')->nullable();
            $table->longText('email_text_success_payment_admin')->nullable();

            $table->string('sms_user')->nullable();
            $table->string('sms_pass')->nullable();
            $table->string('sms_sender_from')->nullable();
            $table->string('sms_text')->nullable();

            $table->string('liqpay_id')->nullable();
            $table->string('liqpay_secret')->nullable();
            $table->string('liqpay_url')->nullable();

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
        Schema::dropIfExists('events');
    }
}
