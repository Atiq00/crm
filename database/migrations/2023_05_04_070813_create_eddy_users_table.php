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
        Schema::create('eddy_users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 120)->nullable();
            $table->string('psedo_name', 120)->nullable();
            $table->string('agent_name', 120)->nullable();
            $table->integer('HRMSID')->default(0);
            $table->string('project_code', 120)->nullable();
            $table->string('type', 100)->nullable();
            $table->integer('status')->default(1);
            $table->timestamp('created_at')->useCurrent();
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
        Schema::dropIfExists('eddy_users');
    }
};
