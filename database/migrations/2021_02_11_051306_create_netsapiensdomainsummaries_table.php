<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetsapiensdomainsummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('netsapiens_domain_summaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('domain', 50); //The domain in ns
            $table->string('description', 50);// The description of the domain
            $table->string('territory', 50);
            $table->integer('call_limit')->nullable();
            $table->integer('max_call_queue')->nullable();
            $table->integer('max_aa')->nullable();
            $table->integer('max_conference')->nullable();
            $table->integer('max_department')->nullable();
            $table->integer('max_user')->nullable();
            $table->integer('current_user')->nullable();
            $table->integer('current_department')->nullable();
            $table->integer('current_queue')->nullable();
            $table->integer('current_agent')->nullable();
            $table->integer('current_park')->nullable();
            $table->integer('current_aa')->nullable();
            $table->integer('current_conference')->nullable();
            $table->integer('current_phonenumbers')->nullable();
            $table->integer('current_tollfree')->nullable();
            $table->integer('current_scope_Basic_User')->nullable();
            $table->integer('current_scope_Call_Center_Agent')->nullable();
            $table->integer('current_scope_Call_Center_Supervisor')->nullable();
            $table->integer('current_scope_NDP')->nullable();
            $table->integer('current_scope_No_Portal')->nullable();
            $table->integer('current_scope_Office_Manager')->nullable();
            $table->integer('current_scope_Reseller')->nullable();
            $table->integer('current_scope_Super_User')->nullable();
            $table->integer('current_service_code_system-aa')->nullable();
            $table->integer('current_service_code_system-conf')->nullable();
            $table->integer('current_service_code_system-department')->nullable();
            $table->integer('current_service_code_system-queue')->nullable();
            $table->integer('current_service_code_system-user')->nullable();
            $table->integer('current_service_code_system-tod')->nullable();
            $table->integer('current_registered_device')->nullable();
            $table->integer('current_transcribe_yes')->nullable();
            $table->integer('current_transcribe_')->nullable();
            $table->integer('current_device')->nullable();
            $table->integer('calculation_time_ms')->nullable();
            $table->integer('active_calls_onnet_last')->nullable();
            $table->integer('active_calls_offnet_last')->nullable();
            $table->integer('active_calls_onnet_current')->nullable();
            $table->integer('active_calls_offnet_current')->nullable();
            $table->integer('sms_inbound_last')->nullable();
            $table->integer('sms_inbound_current')->nullable();
            $table->integer('sms_inbound_today')->nullable();
            $table->integer('sms_outbound_today')->nullable();
            $table->integer('sms_outbound_current')->nullable();
            $table->integer('sms_outbound_last')->nullable();
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
        Schema::dropIfExists('netsapiensdomainsummaries');
    }
}
