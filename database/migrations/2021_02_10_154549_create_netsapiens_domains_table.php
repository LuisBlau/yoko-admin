<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetsapiensDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('netsapiens_domains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('domain', 50); //The domain in ns
            $table->string('territory', 50)->nullable();
            $table->string('dial_match', 50)->nullable();
            $table->string('description', 50);// The description of the domain
            $table->string('moh', 3)->nullable();
            $table->string('mor', 3)->nullable();
            $table->string('mot', 3)->nullable();
            $table->string('rmoh', 3)->nullable();
            $table->string('rating', 3)->nullable();
            $table->string('resi', 3)->nullable();
            $table->string('mksdir', 3)->nullable();
            $table->integer('call_limit')->nullable();
            $table->string('call_limit_ext', 50)->nullable();
            $table->string('sub_limit', 50)->nullable();
            $table->integer('max_call_queue')->nullable();
            $table->integer('max_aa')->nullable();
            $table->integer('max_conference')->nullable();
            $table->integer('max_department')->nullable();
            $table->integer('max_user')->nullable();
            $table->integer('max_device')->nullable();
            $table->string('time_zone', 50)->nullable();           
            $table->string('dial_plan', 50)->nullable();           
            $table->string('dial_policy', 50)->nullable();           
            $table->string('policies', 50)->nullable();           
            $table->string('email_sender', 50)->nullable();           
            $table->string('smtp_host', 50)->nullable();           
            $table->string('smtp_port', 4)->nullable();           
            $table->string('smtp_uid', 50)->nullable();           
            $table->string('smtp_pwd', 50)->nullable();           
            $table->string('from_user', 50)->nullable();           
            $table->string('from_host', 50)->nullable();           
            $table->integer('active_call')->nullable();
            $table->integer('countForLimit')->nullable();
            $table->integer('countExternal')->nullable();
            $table->integer('sub_count')->nullable();
            $table->integer('max_site')->nullable();
            $table->integer('max_fax')->nullable();
            $table->string('sso', 3)->nullable();
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
        Schema::dropIfExists('netsapiens_domains');
    }
}
