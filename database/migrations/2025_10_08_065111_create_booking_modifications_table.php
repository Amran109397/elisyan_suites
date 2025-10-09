<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('booking_modifications', function (Blueprint $table) {
            $table->id();
            
            $table->string('modification_type');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('booking_modifications');
    }
};