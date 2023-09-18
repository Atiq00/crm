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
        Schema::create('cru_sales', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('agent_name', 355)->nullable();
            $table->integer('hrms_id')->nullable()->default(0);
            $table->string('record_id', 11)->nullable()->default('0');
            $table->string('client_code', 100)->nullable();
            $table->string('project_code', 100)->nullable();
            $table->integer('sap_id')->nullable()->default(0);
            $table->text('sap_response')->nullable();
            $table->text('post_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cru_sales');
    }
};
