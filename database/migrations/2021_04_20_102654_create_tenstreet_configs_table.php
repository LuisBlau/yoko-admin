<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenstreetConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenstreet_configs', function (Blueprint $table) {
            $table->id();
            $table->string('domain', 50)->nullable();
            $table->string('queue_name', 50)->nullable();
            $table->string('origination_did', 10)->nullable();
            $table->string('ani_did', 10)->nullable();
            $table->boolean('status'); //1 = active and 0 - not active.
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
        Schema::dropIfExists('tenstreet_configs');
    }
}
