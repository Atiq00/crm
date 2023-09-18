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
        Schema::create('tbb_sales_stats', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('agent_name', 150)->nullable();
            $table->integer('hrms_id')->nullable();
            $table->string('reporting_to_name', 150)->nullable();
            $table->integer('reporting_to_id')->nullable();
            $table->integer('package_request_count')->nullable();
            $table->integer('cruise_request_count')->nullable();
            $table->integer('chat_request_count')->nullable();
            $table->string('avg_time_request', 150)->nullable();
            $table->integer('total_p_c_o_count')->nullable();
            $table->integer('total_req_rec_count')->nullable();
            $table->integer('total_req_resolved_count')->nullable();
            $table->string('total_avg_time', 150)->nullable();
            $table->string('target_ach', 150)->nullable();
            $table->integer('total_agent')->nullable();
            $table->string('Top_performer', 150)->nullable();
            $table->string('quotation_id', 90)->nullable();
            $table->string('project_code', 150)->nullable();
            $table->string('client_code', 150)->nullable();
            $table->integer('sap_id')->nullable();
            $table->text('sap_response')->nullable();
            $table->text('sap_post_data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbb_sales_stats');
    }
};
