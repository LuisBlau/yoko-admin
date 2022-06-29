<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetsapiensdomainextentionswithsmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('netsapiens_domain_extentions_with_sms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number', 20); // The Telephone number
            $table->string('application', 10);
            $table->string('domain', 50); // The customer company or domain
            $table->string('dest', 10); // The extention number
            $table->string('carrier', 50); // The name of the SMS carrier
            $table->boolean('mmsCapable')->default(false)->nullable(); // 1 = Yes and 0 = No
            $table->boolean('groupMMSCapable')->default(false)->nullable(); // 1 = Yes and 0 = No
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
        Schema::dropIfExists('netsapiens_domain_extentions_with_sms');
    }
}
