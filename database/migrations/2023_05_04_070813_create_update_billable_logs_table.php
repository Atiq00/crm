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
        Schema::create('update_billable_logs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('sale_id')->nullable();
            $table->string('type', 120)->nullable();
            $table->string('old_status', 150)->nullable();
            $table->string('new_status', 140)->nullable();
            $table->integer('HRMSID')->nullable();
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
        Schema::dropIfExists('update_billable_logs');
    }
};
