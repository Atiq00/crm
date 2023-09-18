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
        Schema::create('uk_debt', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('client_id')->nullable();
            $table->string('record_id', 30)->nullable();
            $table->integer('campaign_id')->nullable();
            $table->string('client_code', 25)->nullable();
            $table->string('project_code', 25)->nullable();
            $table->string('first_name', 150)->nullable();
            $table->string('last_name', 150)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('client', 120)->nullable();
            $table->string('debt_amount', 100)->nullable();
            $table->string('num_of_creditors', 120)->nullable();
            $table->string('emp_status', 100)->nullable();
            $table->string('monthly_income', 100)->nullable();
            $table->string('house_type', 100)->nullable();
            $table->string('rent_amount', 100)->nullable();
            $table->text('notes')->nullable();
            $table->string('user_id')->nullable();
            $table->integer('sap_id')->nullable();
            $table->text('sap_response')->nullable();
            $table->text('sap_post_data')->nullable();
            $table->enum('qa_status', ['billable', 'not-billable', 'unsuccessfull-transfer', 'pending'])->nullable()->default('pending');
            $table->integer('qa_score')->nullable();
            $table->enum('client_status', ['billable', 'not-billable', 'unsuccessfull-transfer', 'pending'])->nullable()->default('pending');
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->date('updated_at');
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
        Schema::dropIfExists('uk_debt');
    }
};
