// database/migrations/2023_10_01_000005_create_rooms_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->integer('property_id');
            $table->integer('room_type_id');
            $table->integer('floor_id');
            $table->string('room_number');
            $table->enum('status', ['available', 'occupied', 'maintenance', 'cleaning', 'out_of_service', 'blocked', 'renovation']);
            $table->boolean('is_smoking')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};