<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountSystemToPbxClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_system_to_pbx_clients', function (Blueprint $table) {
            $table->id(); // The primary key for the table
            $table->integer('account_id'); // The ID from the accounting_clients table for the given record
            $table->string('domain', 50); // The domain from the netsapiens_domains table
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
        Schema::dropIfExists('account_system_to_pbx_clients');
    }
}
