<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenstreetCallRelayLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenstreet_call_relay_logs', function (Blueprint $table) {
            $table->id();
            $table->string('domain', 50)->nullable(false);
            $table->text('headers')->nullable(false);
            $table->text('body')->nullable(false);
            $table->text('tenstreet_response')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenstreet_call_relay_logs');
    }
}
