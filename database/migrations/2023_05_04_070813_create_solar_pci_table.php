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
        Schema::create('solar_pci', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('record_id')->default(0)->unique('record_id');
            $table->string('first_name', 150)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('state', 120)->nullable();
            $table->string('street_address', 150)->nullable();
            $table->string('phone_number', 120)->nullable();
            $table->string('city', 150)->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->string('credit_score', 15)->nullable();
            $table->string('utility_provider', 150)->nullable();
            $table->string('home_owner', 140)->nullable();
            $table->string('average_monthly_bill', 140)->nullable();
            $table->string('property', 50)->nullable();
            $table->string('cost_on_avg', 100)->nullable();
            $table->string('date', 120)->nullable();
            $table->string('msg', 900)->nullable();
            $table->string('url', 150)->nullable();
            $table->string('type', 50)->nullable();
            $table->enum('status', ['Accept', 'Reject', 'Closed'])->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
            $table->string('post_data', 2000)->nullable();
            $table->string('post_response', 1000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solar_pci');
    }
};
