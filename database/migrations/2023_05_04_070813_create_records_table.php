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
        Schema::create('records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('client_id');
            $table->integer('campaign_id');
            $table->string('first_name', 70);
            $table->string('last_name', 70);
            $table->string('address', 200);
            $table->string('city', 50);
            $table->string('state', 20);
            $table->string('zipcode', 5);
            $table->bigInteger('phone');
            $table->string('email')->unique();
            $table->string('lead_id', 100);
            $table->string('home_owner', 20);
            $table->string('property_type', 40);
            $table->string('electric_bill', 40);
            $table->string('electric_provider', 100);
            $table->string('roof_shade', 50);
            $table->string('credit_score', 60);
            $table->string('income', 50);
            $table->double('age', 8, 2);
            $table->string('notes');
            $table->string('add_info');
            $table->string('add_info_1');
            $table->enum('status', ['Active', 'Disable']);
            $table->integer('agent_id')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->string('credit_rating')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
};
