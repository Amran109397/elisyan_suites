// database/migrations/2023_10_01_000006_create_guests_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unique()->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('id_type', ['passport', 'nid', 'driving_license', 'other'])->nullable();
            $table->string('id_number')->nullable();
            $table->string('id_image_path')->nullable();
            $table->string('nationality')->nullable();
            $table->text('address')->nullable();
            $table->boolean('vip_status')->default(false);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};