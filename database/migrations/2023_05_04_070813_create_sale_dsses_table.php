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
        Schema::create('sale_dsses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_id', 11)->nullable();
            $table->integer('campaign_id')->nullable();
            $table->integer('record_id')->nullable();
            $table->bigInteger('customer_no')->nullable();
            $table->string('first_name', 255)->nullable();
            $table->string('last_name', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 20)->nullable();
            $table->string('zipcode', 5)->nullable();
            $table->bigInteger('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('area', 90)->nullable();
            $table->string('question_1', 90)->nullable();
            $table->string('question_3', 255);
            $table->string('question_4', 255)->nullable();
            $table->string('question_3_1', 255)->nullable();
            $table->string('question_3_2', 255)->nullable();
            $table->string('question_2', 90)->nullable();
            $table->string('others_question_1', 90)->nullable();
            $table->string('others_question_2', 90)->nullable();
            $table->string('customer_name', 90)->nullable();
            $table->string('comments', 300)->nullable();
            $table->string('promo_code', 90)->nullable();
            $table->timestamps();
            $table->string('user_id')->nullable();
            $table->string('project_id', 11)->nullable();
            $table->string('project_code', 11)->nullable();
            $table->string('client_code', 11);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_dsses');
    }
};
