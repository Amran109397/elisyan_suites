// database/migrations/2023_10_01_000003_create_floors_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('floors', function (Blueprint $table) {
            $table->id();
            $table->integer('property_id');
            $table->integer('floor_number');
            $table->string('name');
            $table->timestamps();
            

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('floors');
    }
};