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
        Schema::create('delivery_boys', function (Blueprint $table) {
            $table->id();
            $table->string('restaurant_id');
            $table->string('name');
            $table->string('mobile');
            $table->string('email');
            $table->string('password');
            $table->string('temp_pass');
            $table->string('image');
            $table->string('verified');
            $table->integer('status');
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
        Schema::dropIfExists('delivery_boys');
    }
};
