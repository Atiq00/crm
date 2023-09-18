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
        Schema::create('cru_data', function (Blueprint $table) {
            $table->text('agent_name')->nullable();
            $table->integer('record_id')->nullable();
            $table->text('created_at')->nullable();
            $table->text('client_code')->nullable();
            $table->text('project_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cru_data');
    }
};
