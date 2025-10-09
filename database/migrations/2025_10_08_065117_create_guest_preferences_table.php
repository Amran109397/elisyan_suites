<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('guest_preferences', function (Blueprint $table) {
            $table->id();
           
            $table->string('preference_type');
            $table->string('preference_value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guest_preferences');
    }
};