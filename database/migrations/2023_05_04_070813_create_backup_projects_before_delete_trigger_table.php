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
        Schema::create('backup_projects_before_delete_trigger', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 190)->nullable();
            $table->string('project_code', 100)->nullable()->unique('project_code');
            $table->string('pro_real_name', 255)->nullable();
            $table->unsignedBigInteger('client_id')->nullable()->index('projects_client_id_foreign');
            $table->enum('isFixed', ['0', '1'])->nullable()->default('0');
            $table->integer('hours')->nullable()->default(0);
            $table->integer('seats')->nullable()->default(0);
            $table->string('abbrivation', 120)->nullable();
            $table->integer('sap_status')->nullable()->default(0);
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
        Schema::dropIfExists('backup_projects_before_delete_trigger');
    }
};
