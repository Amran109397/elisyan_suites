<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('booking_services', function (Blueprint $table) {
            $table->id();
           
            $table->integer('quantity');
            $table->decimal('price', 12, 2);
            $table->date('service_date')->nullable();
            $table->time('service_time')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('booking_services');
    }
};