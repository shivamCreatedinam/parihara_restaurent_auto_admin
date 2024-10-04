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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('restaurant_id');
            $table->string('restaurant_name');
            $table->string('owner_name');
            $table->string('email');
            $table->string('mobile');
            $table->string('password');
            $table->string('open_times')->nullable();
            $table->string('close_status')->nullable();
            $table->string('address')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('restaurants');
    }
};
