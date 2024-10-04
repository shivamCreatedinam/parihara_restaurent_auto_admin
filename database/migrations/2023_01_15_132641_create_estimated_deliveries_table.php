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
        Schema::create('estimated_deliveries', function (Blueprint $table) {
            $table->id();
            $table->integer('estimated_km');
            $table->string('days');
            $table->integer('status');
            $table->date('created_date');
            $table->string('created_time');
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
        Schema::dropIfExists('estimated_deliveries');
    }
};
