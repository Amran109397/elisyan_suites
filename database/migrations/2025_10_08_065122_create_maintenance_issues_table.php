<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('maintenance_issues', function (Blueprint $table) {
            $table->id();
            
            $table->string('issue_type');
            $table->text('description');
            $table->enum('status', ['reported', 'in_progress', 'resolved', 'cancelled'])->default('reported');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('maintenance_issues');
    }
};