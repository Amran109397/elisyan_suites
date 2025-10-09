<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('check_outs', function (Blueprint $table) {
            $table->id();
            $table->decimal('final_bill', 12, 2);
            $table->enum('payment_status', ['pending', 'paid', 'partial'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('actual_check_out');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('check_outs');
    }
};