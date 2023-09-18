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
        Schema::create('backup_solar_before_delete', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('campaign_id', 15)->nullable();
            $table->string('record_id', 30)->nullable()->default('0')->unique('record_id');
            $table->text('xxTrustedFormCertUrl')->nullable();
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('street', 190)->nullable();
            $table->string('city', 150)->nullable();
            $table->string('state', 20)->nullable();
            $table->string('zipcode', 5)->nullable();
            $table->bigInteger('phone')->nullable();
            $table->string('work_phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('lead_id', 100)->nullable();
            $table->string('lead_id_point', 100)->nullable();
            $table->string('optin_cert', 255)->nullable();
            $table->string('vendor_lead_id', 255)->nullable();
            $table->string('housetype', 255)->nullable();
            $table->string('state_sm', 255)->nullable();
            $table->string('home_owner', 20)->nullable();
            $table->string('solar_rep', 255)->nullable();
            $table->string('property_type', 40)->nullable();
            $table->string('electric_bill', 40)->nullable();
            $table->string('electric_provider', 100)->nullable();
            $table->string('roof_shade', 50)->nullable();
            $table->string('monthly_payment', 255)->nullable();
            $table->string('credit_score', 60)->nullable();
            $table->string('credit_rating', 50)->nullable();
            $table->string('income', 50)->nullable();
            $table->double('age', 8, 2)->nullable();
            $table->string('smoker', 50)->nullable();
            $table->string('beneficiary', 50)->nullable();
            $table->string('major_health_issues', 50)->nullable();
            $table->string('coverage', 50)->nullable();
            $table->string('notes', 300)->nullable();
            $table->string('add_info')->nullable();
            $table->string('add_info_1')->nullable();
            $table->enum('status', ['Active', 'Disable'])->nullable()->default('Active');
            $table->string('m_status', 255)->nullable();
            $table->enum('qa_status', ['billable', 'not-billable', 'unsuccessfull-transfer', 'pending'])->nullable()->default('pending');
            $table->integer('qa_score')->nullable()->default(0);
            $table->string('qa_notes', 450)->nullable();
            $table->enum('client_status', ['billable', 'not-billable', 'unsuccessfull-transfer', 'pending'])->nullable()->default('pending');
            $table->string('client_remarks', 255)->nullable();
            $table->integer('agent_revnue')->nullable()->default(0);
            $table->integer('client_billed')->nullable()->default(0);
            $table->string('status_sm', 150)->nullable();
            $table->integer('action_by_director')->nullable()->default(0);
            $table->softDeletes();
            $table->integer('user_id')->nullable()->default(0);
            $table->string('call_url', 190)->nullable();
            $table->string('agent_name', 150)->nullable();
            $table->string('app_date_time', 80)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->string('project_code', 150)->nullable()->default('0');
            $table->string('client_code', 150)->nullable()->default('0');
            $table->integer('sap_id')->nullable()->default(0);
            $table->text('sap_response')->nullable();
            $table->text('post_data')->nullable();
            $table->text('sap_post_data')->nullable();
            $table->integer('ip-address')->nullable();
            $table->string('test', 50)->nullable();
            $table->enum('sol', ['0', '1'])->nullable()->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backup_solar_before_delete');
    }
};
