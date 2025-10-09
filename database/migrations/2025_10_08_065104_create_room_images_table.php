<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('room_images', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->string('alt_text');
            $table->boolean('is_primary')->default(false);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('room_images');
    }
};