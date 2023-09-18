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
        Schema::create('sap_logs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('sap_response', 500)->nullable();
            $table->text('sap_post_data')->nullable();
            $table->integer('status')->default(1);
            $table->string('type', 120)->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sap_logs');
    }
};
