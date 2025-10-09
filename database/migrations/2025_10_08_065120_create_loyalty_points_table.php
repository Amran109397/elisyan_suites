<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('loyalty_points', function (Blueprint $table) {
            $table->id();
            
            $table->integer('points');
            $table->string('activity');
            $table->string('reference_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loyalty_points');
    }
};