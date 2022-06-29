<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetsapiensdomainextensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('netsapiens_domain_extensions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('matchrule', 50);
            $table->string('enable', 50);
            $table->string('match_from', 50);
            $table->string('dow', 50);
            $table->string('tod_from', 50);
            $table->string('tod_to', 50);
            $table->string('valid_from', 50);
            $table->string('valid_to', 50);
            $table->string('responder', 50);
            $table->string('parameter', 50);
            $table->string('to_scheme', 50);
            $table->string('to_user', 50);
            $table->string('to_host', 50);
            $table->string('from_name', 50);
            $table->string('from_scheme', 50);
            $table->string('from_user', 50);
            $table->string('from_host', 50);
            $table->string('dialplan', 50);
            $table->string('domain', 50);
            $table->string('plan_description', 50);
            $table->string('domain_owner', 50);
            $table->string('domain_description', 50);
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
        Schema::dropIfExists('netsapiens_domain_extensions');
    }
}
