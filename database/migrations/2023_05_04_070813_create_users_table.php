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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('pass_text', 50)->nullable();
            $table->string('image')->default('6384d60389333.png');
            $table->rememberToken();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->integer('HRMSID')->default(0);
            $table->softDeletes();
            $table->string('pseudo_name', 125)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('cnic', 20)->nullable();
            $table->string('birth_date', 50)->nullable();
            $table->timestamp('campaign_hire_date')->nullable();
            $table->string('employee_status', 50)->nullable();
            $table->string('joining_date', 50)->nullable();
            $table->string('retirement_date', 50)->nullable();
            $table->integer('reporting_to_id')->nullable();
            $table->string('reporting_to_name', 150)->nullable();
            $table->string('designation', 120)->nullable();
            $table->string('campaign', 120)->nullable();
            $table->enum('camp_status', ['Active', 'InActive'])->nullable()->default('Active');
            $table->string('address', 190)->nullable();
            $table->integer('campaign_id')->nullable();
            $table->integer('designation_id')->nullable();
            $table->integer('employement_type_id')->nullable();
            $table->string('type', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
