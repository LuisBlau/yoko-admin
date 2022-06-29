<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_logins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('userid');
            $table->string('ip', 50);
            $table->string('country', 20);
            $table->string('region', 20);
            $table->string('city', 50);
            
            // $table->string('email', 100)->unique();
            // $table->string('image', 500)->nullable(); // The path to the image for the user
            // $table->string('password', 65);
            // $table->string('salt', 65); // The salt used for the password
            // $table->string('reset_token', 65); // The password reset token
            // $table->boolean('status')->default(false); // 1 = Active and 0 = In-Active
            // $table->bigInteger('role_id'); // The ID of the role assigned to the user
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
        Schema::dropIfExists('user_logins');
    }
}
