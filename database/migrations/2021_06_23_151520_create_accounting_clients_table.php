<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountingClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_clients', function (Blueprint $table) {
            $table->id();
            $table->string('client', 50)->nullable();
            $table->string('client_user_name', 50)->nullable();
            $table->string('client_email', 50)->nullable();
            $table->string('bus_phone', 20)->nullable();
            $table->string('accounting_systemid', 50)->nullable();
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
        Schema::dropIfExists('accounting_clients');
    }
}
