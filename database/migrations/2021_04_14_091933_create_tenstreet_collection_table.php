<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenstreetCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenstreet_collections', function (Blueprint $table) {
            $table->id();
            $table->string('domain', 50)->nullable();
            $table->text('headers');
            $table->text('body');
            $table->timestamp('apiDate')->useCurrent();
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
        Schema::dropIfExists('tenstreet_collections');
    }
}
