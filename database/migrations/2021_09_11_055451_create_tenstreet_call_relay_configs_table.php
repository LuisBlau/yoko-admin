<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenstreetCallRelayConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenstreet_call_relay_configs', function (Blueprint $table) {
            $table->id();
            $table->string('subscription_id', 65)->nullable();
            $table->string('destination_url', 255)->nullable();

            $table->foreignId('netsapiens_domain_id')->constrained('netsapiens_domains', 'id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenstreet_call_relay_configs');
    }
}
