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
        Schema::create('cmu_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sale_date', 50)->nullable();
            $table->integer('hrms_id');
            $table->string('name')->nullable();
            $table->string('project_code')->nullable();
            $table->string('client_code', 50)->nullable()->default('CUS-100042');
            $table->integer('count');
            $table->integer('sap_id')->default(0);
            $table->text('sap_response')->nullable();
            $table->text('post_data')->nullable();
            $table->string('client_status', 25)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['sale_date', 'hrms_id', 'project_code'], 'unique_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cmu_sales');
    }
};
