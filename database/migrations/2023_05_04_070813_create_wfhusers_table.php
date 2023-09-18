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
        Schema::create('wfhusers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('HRMSID', 255)->nullable();
            $table->string('CampaignID', 50)->nullable();
            $table->string('camp_name', 150)->nullable();
            $table->string('TL_name', 150)->nullable();
            $table->string('email', 255);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('plain_text', 150)->nullable();
            $table->enum('UserType', ['Agent', 'Manager', 'MkcClient', 'SrwcsClient', 'AlliedClient'])->default('Agent');
            $table->rememberToken();
            $table->integer('Active')->default(1);
            $table->enum('wfh', ['0', '1'])->default('0');
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
        Schema::dropIfExists('wfhusers');
    }
};
