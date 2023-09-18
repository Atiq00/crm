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
        Schema::create('dummy_qms_records', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('VID')->nullable();
            $table->string('Evaluator', 300)->nullable();
            $table->integer('Record_ID')->nullable()->default(0);
            $table->string('Call_Date', 100)->nullable();
            $table->string('Customer_Name', 100)->nullable();
            $table->string('Customer_Phone', 100)->nullable();
            $table->integer('HRMS_ID')->nullable();
            $table->string('Associate', 100)->nullable();
            $table->string('Reporting_To', 100)->nullable();
            $table->string('Campaign', 100)->nullable();
            $table->string('Project', 100)->nullable();
            $table->integer('Result')->nullable();
            $table->string('Outcome', 50)->nullable();
            $table->string('Handling_Time', 100)->nullable();
            $table->string('Call_Time', 100)->nullable();
            $table->string('Evaluation_Date', 100)->nullable();
            $table->text('QA_Notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dummy_qms_records');
    }
};
