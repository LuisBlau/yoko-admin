<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountingDailyBillingCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_daily_billing_counts', function (Blueprint $table) {
            $table->id();
            $table->integer('netsapiens_domain_id'); // The foreign key to the domain in the netsapiens_domains table
            $table->integer('num_of_extensions'); //  The number of extentions for the domain for the given day
            $table->date('date_of_count'); //  The day the count was pulled
            $table->integer('num_of_sms_messages_in'); // The number of SMS In messages for that day
            $table->integer('num_of_mms_messages_in'); // The number of MMS In messages for that day
            $table->integer('num_of_sms_messages_out'); // The number of SMS Out message for that day
            $table->integer('num_of_mms_messages_out'); // The number of MMS Out messages for that day
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
        Schema::dropIfExists('accounting_daily_billing_counts');
    }
}
