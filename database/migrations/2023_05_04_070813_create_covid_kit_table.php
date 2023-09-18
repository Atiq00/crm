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
        Schema::create('covid_kit', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('client_id')->nullable();
            $table->integer('hrms_id');
            $table->integer('campaign_ id')->nullable();
            $table->string('first_name', 150)->nullable();
            $table->string('last_name', 150)->nullable();
            $table->bigInteger('phone')->nullable();
            $table->string('record_id', 30);
            $table->bigInteger('medi_num')->nullable();
            $table->date('dob')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['Active', 'Disable'])->nullable();
            $table->enum('qa_status', ['billable', 'not-billable', 'unsuccessfull-transfer', 'pending'])->nullable();
            $table->enum('client_status', ['billable', 'not-billable', 'unsuccessfull-transfer', 'pending'])->nullable();
            $table->string('client_remarks', 150)->nullable();
            $table->string('project_code', 100)->nullable();
            $table->string('client_code', 100)->nullable();
            $table->text('post_data')->nullable();
            $table->text('post_response')->nullable();
            $table->integer('sap_id')->nullable();
            $table->integer('qa_score')->nullable();
            $table->string('qa_notes', 255)->nullable();
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
        Schema::dropIfExists('covid_kit');
    }
};
