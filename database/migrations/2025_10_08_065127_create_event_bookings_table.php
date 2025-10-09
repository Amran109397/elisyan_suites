<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('event_bookings', function (Blueprint $table) {
            $table->id();
           
            $table->integer('number_of_attendees');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
            $table->decimal('total_price', 12, 2);
            $table->text('special_requests')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_bookings');
    }
};