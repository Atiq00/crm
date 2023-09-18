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
        Schema::create('cru_agent_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cru_id', 255);
            $table->integer('hrms_id');
            $table->string('name', 255);
            $table->string('reporting_to', 500)->nullable();
            $table->string('manager', 500)->nullable();
            $table->enum('skill', ['Basic', 'General', 'Sensitive', 'CRM User'])->default('Basic');
            $table->enum('status', ['Active', 'InActive'])->default('Active');
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
        Schema::dropIfExists('cru_agent_details');
    }
};
