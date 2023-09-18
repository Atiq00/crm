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
        Schema::create('backup_lg_logs_before_delete_trigger', function (Blueprint $table) {
            $table->integer('id');
            $table->text('server_info')->nullable();
            $table->text('post_response')->nullable();
            $table->text('post_data')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backup_lg_logs_before_delete_trigger');
    }
};
