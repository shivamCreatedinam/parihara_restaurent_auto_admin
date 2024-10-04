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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_code');
            $table->float('discount');
            $table->string('discount_type');
            $table->string('user_type');
            $table->integer('total_coupon_count')->nullable();
            $table->integer('used_coupon_count')->nullable();
            $table->longText('description');
            $table->dateTime('valid_from');
            $table->dateTime('expires_on');
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
        Schema::dropIfExists('coupons');
    }
};
