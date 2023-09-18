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
        Schema::create('project_inactive_users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('user_id')->nullable();
            $table->string('project_code', 255)->nullable();
            $table->enum('status', ['Active', 'Inactive'])->nullable()->default('Active');
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
        Schema::dropIfExists('project_inactive_users');
    }
};
