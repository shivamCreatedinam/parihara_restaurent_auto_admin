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
        Schema::create('prod_selctd_attris', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id')->unsigned()->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('attributes_id')->unsigned()->foreign('attributes_id')->references('id')->on('product_attributes')->onUpdate('cascade')->onDelete('cascade');
            $table->float('mrp');
            $table->float('saling_price');
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
        Schema::dropIfExists('prod_selctd_attris');
    }
};
