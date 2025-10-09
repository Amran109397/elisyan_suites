<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('loyalty_members', function (Blueprint $table) {
            $table->id();
           
            $table->integer('points')->default(0);
            $table->string('tier')->default('bronze');
            $table->date('join_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loyalty_members');
    }
};