<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voice_audits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('voice_evaluation_id');
            $table->integer('user_id');
            $table->integer('associate_id');
            $table->integer('team_lead_id')->nullable();
            $table->integer('campaign_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->date('call_date')->nullable();
            $table->double('percentage', 8, 2)->default(0);
            $table->string('customer_name', 255)->nullable();
            $table->string('customer_phone', 255)->nullable();
            $table->string('record_id', 255)->nullable();
            $table->time('recording_duration')->nullable();
            $table->text('recording_link')->nullable();
            $table->enum('outcome', ['pending', 'accepted', 'rejected'])->default('accepted');
            $table->longText('notes')->nullable();
            $table->integer('crm_status')->default(0);
            $table->unsignedInteger('review_priority')->default(0);
            $table->enum('status', ['evaluated', 'appeal requested', 'appeal accepted', 'appeal rejected', 'action taken', 'assigned to team lead'])->default('evaluated');
            $table->time('evaluation_time')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('voice_audits');
    }
};
