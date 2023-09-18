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
        Schema::create('knowledge_bases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description');
            $table->integer('helpful_yes')->default(0);
            $table->integer('helpful_no')->default(0);
            $table->bigInteger('views')->default(0);
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
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
        Schema::dropIfExists('knowledge_bases');
    }
};
