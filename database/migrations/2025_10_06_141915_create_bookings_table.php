// database/migrations/2023_10_01_000007_create_bookings_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('property_id');
            $table->integer('guest_id');
            $table->integer('room_id')->nullable();
            $table->integer('room_type_id');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('total_nights');
            $table->integer('adults')->default(1);
            $table->integer('children')->default(0);
            $table->integer('infants')->default(0);
            $table->text('special_requests')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled', 'no_show', 'modified']);
            $table->enum('booking_source', ['website', 'walk_in', 'phone', 'ota', 'travel_agent', 'corporate']);
            $table->string('booking_reference')->unique();
            $table->decimal('total_price', 12, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};