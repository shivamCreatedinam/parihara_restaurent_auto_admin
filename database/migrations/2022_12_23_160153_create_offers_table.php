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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned()->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned()->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->string('offer_name');
            $table->string('offer_type');
            $table->dateTime('offer_start_from');
            $table->dateTime('offer_expires_on');
            $table->integer('status');
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
        Schema::dropIfExists('offers');
    }
};
