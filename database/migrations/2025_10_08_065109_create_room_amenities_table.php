<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('room_amenities', function (Blueprint $table) {
            $table->timestamps();
            
            $table->primary(['room_type_id', 'amenity_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('room_amenities');
    }
};