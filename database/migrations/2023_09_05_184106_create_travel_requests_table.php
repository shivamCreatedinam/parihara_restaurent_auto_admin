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
        Schema::create('travel_requests', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('driver_id')->nullable();
            $table->string('from_address')->nullable();
            $table->string('from_state')->nullable();
            $table->string('from_city')->nullable();
            $table->string('from_pincode')->nullable();
            $table->string('from_lat')->nullable();
            $table->string('from_long')->nullable();
            $table->string('distance')->nullable();
            $table->integer('price')->nullable();
            $table->string('to_address')->nullable();
            $table->string('to_state')->nullable();
            $table->string('to_city')->nullable();
            $table->string('to_pincode')->nullable();
            $table->string('to_lat')->nullable();
            $table->string('to_long')->nullable();
            $table->integer('status')->default(0);
            $table->dateTime('created_date');
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
        Schema::dropIfExists('travel_requests');
    }
};
