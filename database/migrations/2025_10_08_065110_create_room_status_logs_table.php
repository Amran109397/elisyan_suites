<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('room_status_logs', function (Blueprint $table) {
            $table->id();
           
            $table->enum('status', ['available', 'occupied', 'maintenance', 'cleaning', 'out_of_service', 'blocked', 'renovation']);
            
            $table->timestamp('changed_at');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('room_status_logs');
    }
};