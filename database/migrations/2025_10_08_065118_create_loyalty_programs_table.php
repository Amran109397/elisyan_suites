<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('loyalty_programs', function (Blueprint $table) {
            $table->id();
            
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('points_per_currency', 10, 2)->default(1.00);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loyalty_programs');
    }
};