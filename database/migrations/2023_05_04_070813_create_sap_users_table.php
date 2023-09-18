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
        Schema::create('sap_users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('HRMSID', 15)->default('0')->unique('HRMSID');
            $table->string('EMPPOSITION', 190)->nullable();
            $table->string('EMPNAME', 190)->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('sap_users');
    }
};
