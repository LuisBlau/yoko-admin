php artisan make:seeder UserSeeder<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('apicollections');
        
        Schema::create('apicollections', function (Blueprint $table) {
            $table->id();
            $table->integer('message_id');
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
        Schema::dropIfExists('apicollections');
    }
}
