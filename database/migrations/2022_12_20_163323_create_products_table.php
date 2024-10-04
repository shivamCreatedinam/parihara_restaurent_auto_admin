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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned()->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('attribute_id')->unsigned()->foreign('attribute_id')->references('id')->on('product_attributes')->onUpdate('cascade')->onDelete('cascade');
            $table->string('product_name');
            $table->string('product_code');
            $table->string('market_price');
            $table->string('discount');
            $table->string('sale_price');
            $table->integer('qty');
            $table->longText('description');
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
        Schema::dropIfExists('products');
    }
};
