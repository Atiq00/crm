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
        Schema::create('home_warranty_external', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('notes')->nullable();
            $table->string('square_feet', 255)->nullable();
            $table->string('client', 100)->nullable();
            $table->text('post_data')->nullable();
            $table->text('post_response')->nullable();
            $table->integer('hrms_id')->nullable();
            $table->integer('campaign_id')->default(1);
            $table->integer('record_id')->nullable();
            $table->enum('status', ['Accepted', 'Rejected', 'Unsuccessful Transfer', 'Pending'])->nullable()->default('Pending');
            $table->string('type', 120)->nullable();
            $table->enum('qa_status', ['billable', 'not-billable', 'unsuccessfull-transfer', 'pending'])->nullable()->default('pending');
            $table->enum('client_status', ['billable', 'not-billable', 'unsuccessfull-transfer', 'pending'])->nullable()->default('pending');
            $table->string('remarks')->nullable();
            $table->string('closers', 210)->nullable();
            $table->string('buffer', 250)->nullable();
            $table->string('other_closers', 210)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->string('project_code', 290)->nullable()->default('PRO0184');
            $table->string('client_code', 290)->nullable()->default('CUS-100077');
            $table->integer('agent_revnue')->nullable()->default(0);
            $table->integer('client_billed')->nullable()->default(0);
            $table->integer('action_by_director')->nullable()->default(0);
            $table->integer('sap_id')->nullable()->default(0);
            $table->integer('qa_score')->default(0);
            $table->text('sap_response')->nullable();
            $table->text('sap_post_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_warranty_external');
    }
};
