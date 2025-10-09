<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('check_ins', function (Blueprint $table) {
            $table->id();
            $table->string('id_document_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('actual_check_in');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('check_ins');
    }
};