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
        Schema::create('backup_client_postings_before_trigger', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->integer('campaign_id')->nullable()->default(0);
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->text('post_data')->nullable();
            $table->text('post_response')->nullable();
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
        Schema::dropIfExists('backup_client_postings_before_trigger');
    }
};
