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
        Schema::create('backup_clients_before_delete_trigger', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('client_code')->nullable()->default('\'\'0\'\'');
            $table->string('name')->nullable();
            $table->unsignedBigInteger('campaign_id')->nullable();
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
        Schema::dropIfExists('backup_clients_before_delete_trigger');
    }
};
