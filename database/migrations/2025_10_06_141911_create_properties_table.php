// database/migrations/2023_10_01_000001_create_properties_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->time('check_in_time')->default('14:00:00');
            $table->time('check_out_time')->default('12:00:00');
            $table->string('timezone')->default('UTC');
            $table->integer('currency_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};