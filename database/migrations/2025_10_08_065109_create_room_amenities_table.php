<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('room_amenities', function (Blueprint $table) {
            // ✅ FIRST CREATE THE COLUMNS
            $table->foreignId('room_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('amenity_id')->constrained()->onDelete('cascade');
            
            // ✅ THEN SET PRIMARY KEY
            $table->primary(['room_type_id', 'amenity_id']);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('room_amenities');
    }
};