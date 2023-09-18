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
        Schema::create('seatbased_sap_response', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('sap_id')->nullable()->default(0);
            $table->text('post_data')->nullable();
            $table->text('sap_response')->nullable();
            $table->string('users', 4000)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seatbased_sap_response');
    }
};
