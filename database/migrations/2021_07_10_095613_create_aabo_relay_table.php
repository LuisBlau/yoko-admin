<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAaboRelayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aabo_relay', function (Blueprint $table) {
            $table->id(); //The primary key for the table
            $table->integer('extension_id'); // The Foreign Key to the netsapiens_domain_extensions table
            $table->string('destination_url', 50); // The domain that the message gets relayed to
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
        Schema::dropIfExists('aabo_relay');
    }
}
