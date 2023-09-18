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
        Schema::create('backup_users_triggers_before_delete_trigger', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->string('password')->nullable();
            $table->string('pass_text', 50)->nullable();
            $table->string('image')->nullable();
            $table->rememberToken();
            $table->timestamp('created_at')->nullable()->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->nullable()->default('0000-00-00 00:00:00');
            $table->integer('HRMSID')->nullable();
            $table->softDeletes()->default('0000-00-00 00:00:00');
            $table->string('pseudo_name', 125)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('cnic', 20)->nullable();
            $table->string('birth_date', 50)->nullable();
            $table->timestamp('campaign_hire_date')->nullable()->default('0000-00-00 00:00:00');
            $table->string('employee_status', 50)->nullable();
            $table->string('joining_date', 50)->nullable();
            $table->string('retirement_date', 50)->nullable();
            $table->integer('reporting_to_id')->nullable();
            $table->string('reporting_to_name', 150)->nullable();
            $table->string('designation', 120)->nullable();
            $table->string('campaign', 120)->nullable();
            $table->enum('camp_status', ['Active', 'InActive'])->nullable();
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
        Schema::dropIfExists('backup_users_triggers_before_delete_trigger');
    }
};
