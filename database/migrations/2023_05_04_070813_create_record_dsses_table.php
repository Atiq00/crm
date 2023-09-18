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
        Schema::create('record_dsses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('client_id');
            $table->integer('campaign_id');
            $table->integer('dssdatafile_id');
            $table->bigInteger('customer_no');
            $table->string('first_name', 70);
            $table->string('last_name', 70);
            $table->string('address', 200);
            $table->string('city', 50);
            $table->string('state', 20);
            $table->string('zipcode', 5);
            $table->bigInteger('phone');
            $table->string('email');
            $table->string('area', 90);
            $table->integer('user_id');
            $table->timestamps();
            $table->string('customer_name', 90)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('record_dsses');
    }
};
