<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('inbound'); //1 = inbound and 0 = outbound
            $table->string('from', 15); //The phone number the message was from
            $table->string('recipients', 150); //The list of recipient numbers
            $table->string('ccRecipients', 150)->nullable(); //Optional list of CC recipient numbers
            $table->text('text')->nullable();; //The text of the message
            $table->string('mediaURL', 500)->nullable(); //Optional media URL
            $table->string('carrier', 50)->nullable(); //The name of the carrier used
            $table->string('responseText', 50)->nullable(); //result
            $table->timestamp('created_on')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_logs');
    }
}
