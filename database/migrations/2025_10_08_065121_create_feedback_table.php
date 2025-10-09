<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
           
          
            $table->integer('rating');
            $table->string('category')->nullable();
            $table->text('comments');
            $table->enum('status', ['new', 'reviewed', 'resolved', 'dismissed'])->default('new');
            $table->text('response')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedback');
    }
};