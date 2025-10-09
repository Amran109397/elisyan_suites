<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('waiting_lists', function (Blueprint $table) {
            $table->id();
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('adults');
            $table->integer('children')->default(0);
            $table->enum('status', ['waiting', 'contacted', 'booked', 'cancelled'])->default('waiting');
            $table->integer('priority')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('waiting_lists');
    }
};