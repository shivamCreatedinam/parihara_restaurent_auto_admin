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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('driver_id');
            $table->string('name');
            $table->string('mobile');
            $table->string('email');
            $table->string('password');
            $table->string('temp_pass');
            $table->string('drv_image');
            $table->string('vehicle_no');
            $table->longText('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('aadhar_front');
            $table->string('aadhar_back');
            $table->string('drv_licence');
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
        Schema::dropIfExists('drivers');
    }
};
