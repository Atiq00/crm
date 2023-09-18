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
        Schema::create('sale_mortgages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('record_id')->nullable();
            $table->integer('campaign_id')->nullable();
            $table->string('first_name', 70)->nullable();
            $table->string('last_name', 70)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 20)->nullable();
            $table->string('zipcode', 8)->nullable();
            $table->bigInteger('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('debt', 255)->nullable();
            $table->string('total_debt', 100)->nullable();
            $table->double('age', 8, 2)->nullable();
            $table->string('age_18_to_64', 255)->nullable();
            $table->string('debt_type', 255)->nullable();
            $table->string('loan_type')->nullable();
            $table->string('lender', 255)->nullable();
            $table->string('loan_balance', 255)->nullable();
            $table->string('purpose_of_loan')->nullable();
            $table->string('mortgage_balance')->nullable();
            $table->string('interest_rate')->nullable();
            $table->string('credit_score', 60)->nullable();
            $table->string('annual_house', 255)->nullable();
            $table->string('credit_rating', 60)->nullable();
            $table->string('work_phone')->nullable();
            $table->string('house_value')->nullable();
            $table->string('best_timing')->nullable();
            $table->string('cash_amount')->nullable();
            $table->string('current_amount')->nullable();
            $table->string('current_rate')->nullable();
            $table->string('property_type', 40)->nullable();
            $table->string('property_value')->nullable();
            $table->string('income', 50)->nullable();
            $table->string('dob', 50)->nullable();
            $table->string('notes')->nullable();
            $table->string('recieving_rep', 120)->nullable();
            $table->string('monthly_payment')->nullable();
            $table->string('late_payment')->nullable();
            $table->string('ltv')->nullable();
            $table->string('cash_out')->nullable();
            $table->string('loan_amount')->nullable();
            $table->string('medicare_medicaid', 255)->nullable();
            $table->string('rate_type')->nullable();
            $table->string('transfer_by')->nullable();
            $table->string('call_transfer_status')->nullable();
            $table->string('loanofficername')->nullable();
            $table->enum('status', ['Active', 'Disable'])->nullable();
            $table->enum('qa_status', ['billable', 'not-billable', 'unsuccessfull-transfer', 'pending'])->nullable()->default('pending');
            $table->enum('client_status', ['billable', 'not-billable', 'unsuccessfull-transfer', 'pending'])->nullable()->default('pending');
            $table->text('client_remarks');
            $table->integer('agent_revnue')->nullable()->default(0);
            $table->integer('client_billed')->nullable()->default(0);
            $table->integer('action_by_director')->nullable()->default(0);
            $table->integer('user_id')->nullable()->default(0);
            $table->string('pseudo_name', 150)->nullable();
            $table->text('post_data')->nullable();
            $table->string('company')->nullable();
            $table->string('employment', 120)->nullable();
            $table->string('bankrupty', 120)->nullable();
            $table->string('transferred_to', 255)->nullable();
            $table->string('transferred_to_lb2417', 255)->nullable();
            $table->string('r_transfer_to_1380', 150)->nullable();
            $table->string('behindPmts', 255)->nullable();
            $table->string('debt_amt_1', 255)->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->nullable();
            $table->string('project_code', 100)->nullable()->default('0');
            $table->string('client_code', 150)->nullable()->default('0');
            $table->integer('sap_id')->nullable()->default(0);
            $table->integer('qa_score')->default(0);
            $table->string('qa_notes', 450)->nullable();
            $table->text('sap_response')->nullable();
            $table->text('sap_post_data')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->string('Insurance_company_name', 255)->nullable();
            $table->string('home_owner', 150)->nullable();
            $table->string('campaign_name', 120)->nullable();
            $table->string('designation', 120)->nullable();
            $table->integer('reporting_to')->nullable()->default(0);
            $table->string('reporting_to_name', 140)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_mortgages');
    }
};
