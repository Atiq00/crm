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
        Schema::create('latest_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('EMPLOYEE_ID', 15)->default('0');
            $table->string('email')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->integer('HRMSID')->default(0);
            $table->string('phone', 15)->nullable();
            $table->string('cnic', 20)->nullable();
            $table->string('birth_date', 50)->nullable();
            $table->string('employee_status', 50)->nullable();
            $table->string('joining_date', 50)->nullable();
            $table->string('retirement_date', 50)->nullable();
            $table->integer('reporting_to_id')->nullable();
            $table->string('reporting_to_name', 150)->nullable();
            $table->string('designation', 120)->nullable();
            $table->string('campaign', 120)->nullable();
            $table->string('org_location', 190)->nullable();
            $table->string('address', 190)->nullable();
            $table->integer('campaign_id')->nullable();
            $table->integer('designation_id')->nullable();
            $table->integer('employement_type_id')->nullable();
            $table->integer('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('latest_users');
    }
};
