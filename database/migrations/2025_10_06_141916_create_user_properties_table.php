// database/migrations/2023_10_01_000010_create_user_properties_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_properties', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('property_id');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();
            
            $table->primary(['user_id', 'property_id']);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_properties');
    }
};