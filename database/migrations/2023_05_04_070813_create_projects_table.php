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
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 190);
            $table->string('project_code', 100)->unique('project_code');
            $table->string('pro_real_name', 255)->nullable();
            $table->unsignedBigInteger('client_id')->index('projects_client_id_foreign');
            $table->enum('isFixed', ['0', '1'])->default('0');
            $table->integer('hours')->default(0);
            $table->integer('seats')->default(0);
            $table->string('abbrivation', 120)->nullable();
            $table->integer('sap_status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
