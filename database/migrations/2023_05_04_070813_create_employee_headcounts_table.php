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
        Schema::create('employee_headcounts', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('hrms_id', 10)->nullable();
            $table->string('auto_hrms_id', 10)->nullable();
            $table->string('reporting_to', 11)->nullable();
            $table->string('first_name', 255)->nullable();
            $table->string('middle_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('email', 300)->nullable();
            $table->string('status', 255)->nullable();
            $table->string('campaign', 255)->nullable();
            $table->string('designation', 255)->nullable();
            $table->string('reporting_name', 255)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('cnic', 20)->nullable();
            $table->string('pseudo_name', 255)->nullable();
            $table->date('joining_date')->nullable();
            $table->date('retirement_date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('employee_headcounts');
    }
};
