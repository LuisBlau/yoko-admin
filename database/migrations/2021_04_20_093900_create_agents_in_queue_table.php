<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsInQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents_in_queue', function (Blueprint $table) {
            $table->id();
            $table->string('device_aor', 50)->nullable();
            $table->string('huntgroup_name', 50)->nullable();
            $table->string('huntgroup_domain', 50)->nullable();
            $table->string('entry_option', 50)->nullable();
            $table->integer('wrap_up_sec')->nullable();
            $table->string('auto_ans', 20)->nullable();
            $table->integer('entry_order')->nullable();
            $table->integer('entry_priority')->nullable();
            $table->integer('call_limit')->nullable();
            $table->string('confirm_required', 20)->nullable();
            $table->string('entry_device', 20)->nullable();
            $table->string('entry_status', 20)->nullable();
            $table->string('owner_user', 50)->nullable();
            $table->string('owner_domain', 50)->nullable();
            $table->integer('session_count')->nullable();
            $table->string('error_info', 50)->nullable();
            $table->dateTime('last_update')->nullable();
            $table->integer('max_sms')->nullable();
            $table->integer('last_dispatch_ts')->nullable();
            $table->integer('device')->nullable();
            $table->string('stat', 50)->nullable();
            $table->string('sub_user', 50)->nullable();
            $table->string('sub_domain', 50)->nullable();
            $table->string('sub_login', 50)->nullable();
            $table->string('sub_fullname', 50)->nullable();
            $table->string('sub_firstname', 50)->nullable();
            $table->string('sub_lastname', 50)->nullable();
            $table->string('sub_group', 50)->nullable();
            $table->string('sub_site', 50)->nullable();
            $table->string('sub_scope', 50)->nullable();
            $table->string('sub_portal_status', 50)->nullable();
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
        Schema::dropIfExists('agents_in_queue');
    }
}
