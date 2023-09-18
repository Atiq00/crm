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
        Schema::create('eddy_sales', function (Blueprint $table) {
            $table->integer('id', true);
            $table->date('sale_date')->nullable();
            $table->integer('hrms_id')->default(0);
            $table->string('agent_id', 120)->nullable();
            $table->string('billable_hours', 50)->nullable()->default('0');
            $table->string('call_hours', 10)->nullable()->default('0');
            $table->string('calls_per_billable_hours', 10)->nullable()->default('0');
            $table->string('total_calls', 10)->nullable()->default('0');
            $table->string('total_connects', 50);
            $table->string('connects', 50)->default('0');
            $table->string('connect_percentage', 10)->default('0');
            $table->string('deassign_percentage', 10)->default('0');
            $table->string('aht', 10)->default('0');
            $table->integer('edu_transfers')->default(0);
            $table->string('edu_cph', 50);
            $table->string('edu_tph', 50);
            $table->string('edu_transfer_rate', 10)->default('0');
            $table->string('edu_conversions', 50)->default('0');
            $table->string('edu_conv_percentage_of_transfers', 5)->default('0');
            $table->string('edu_conv_percentage_of_connects', 5)->default('0');
            $table->string('edu_conv_percentage_of_total_calls', 11)->default('0');
            $table->integer('transfers')->default(0);
            $table->string('transfers_percentage', 5)->default('0');
            $table->string('type', 100)->nullable();
            $table->string('people', 50)->default('0');
            $table->string('forms', 50)->default('0');
            $table->string('lts', 50)->default('0');
            $table->string('conv_percentage', 50)->default('0');
            $table->string('lt_percentage', 50)->nullable();
            $table->string('lpp', 5)->default('0');
            $table->string('lph', 5)->default('0');
            $table->string('wlph', 5)->default('0');
            $table->string('pph', 5)->default('0');
            $table->string('wlpc', 5)->default('0');
            $table->string('client_code', 50)->nullable()->default('CUS-100062');
            $table->string('project_code', 50)->nullable();
            $table->string('sap_id', 50)->default('0');
            $table->text('post_response')->nullable();
            $table->text('sap_response')->nullable();
            $table->text('post_data')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eddy_sales');
    }
};
