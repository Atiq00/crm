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
        Schema::create('call_analytic_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sale_date', 100);
            $table->integer('hrms_id');
            $table->string('name', 300);
            $table->string('project_code');
            $table->integer('count');
            $table->integer('sap_id')->default(0);
            $table->text('sap_response')->nullable();
            $table->text('post_data')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('call_analytic_sales');
    }
};
