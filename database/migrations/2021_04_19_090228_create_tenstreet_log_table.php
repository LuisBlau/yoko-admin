<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenstreetLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenstreet_log', function (Blueprint $table) {
            $table->id();
            $table->string('subjectid', 50)->nullable();
            $table->string('domain', 50)->nullable();
            $table->string('firstname', 50)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->string('pphone', 50)->nullable();
            $table->string('sphone', 50)->nullable();
            $table->string('autocall', 50)->nullable();
            $table->string('source', 50)->nullable();
            $table->string('status', 10)->nullable();
            $table->boolean('after_hours')->default(false)->nullable(); //(1 = True 0 = False)
            $table->timestamp('call_date')->nullable();
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
        Schema::dropIfExists('tenstreet_log');
    }
}
