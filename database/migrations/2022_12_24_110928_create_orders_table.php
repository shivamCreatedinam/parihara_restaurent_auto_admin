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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('order_number');
            $table->string('applied_coupon_code')->nullable();
            $table->string('discount_value')->nullable();
            $table->float('discount_amount')->nullable();
            $table->float('delvery_charge');
            $table->float('sub_total');
            $table->float('grand_total');
            $table->string('slot_id');
            $table->string('selected_slot');
            $table->string('address_id');
            $table->string('full_name');
            $table->string('mobile');
            $table->string('house_no');
            $table->string('appartment');
            $table->string('city');
            $table->string('state');
            $table->string('pincode');
            $table->string('address_type');
            $table->string('payment_mode');
            $table->string('payment_status');
            $table->string('order_status');
            $table->string('created_date');
            $table->string('created_time');
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
        Schema::dropIfExists('orders');
    }
};
