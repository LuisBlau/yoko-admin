<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->unique();
            $table->string('email', 100)->unique();
            $table->boolean('customer_admin')->default(false); //boolean - 1 = Yes 0 = No
            $table->string('image', 500)->nullable(); // The path to the image for the user
            $table->string('password', 65)->nullable();
            $table->string('salt', 65)->nullable(); // The salt used for the password
            $table->string('reset_token', 65)->nullable(); // The password reset token
            $table->string('verification_token', 65)->nullable(); // The verification token
            $table->boolean('status')->default(false); // 1 = Active and 0 = In-Active
            $table->bigInteger('role_id')->default(1); // The ID of the role assigned to the user
            
            // $table->string('firstname', 50)->default('_');
            // $table->string('lastname', 50)->default('_');
            // $table->string('phone', 20)->nullable();
            // $table->string('streetaddress', 120)->nullable();
            // $table->string('apt', 20)->nullable();
            // $table->string('city', 20)->nullable();
            // $table->string('state', 20)->nullable();
            // $table->string('zip', 20)->nullable();
            $table->dateTime('lastaccessed')->nullable();
            $table->string('active', 10)->default('Active');
            $table->string('api_token')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
