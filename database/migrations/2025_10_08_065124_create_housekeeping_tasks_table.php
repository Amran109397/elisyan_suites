<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('housekeeping_tasks', function (Blueprint $table) {
            $table->id();
           
            $table->enum('task_type', ['cleaning', 'maintenance', 'inspection', 'turndown']);
            $table->enum('status', ['assigned', 'in_progress', 'completed', 'cancelled', 'skipped'])->default('assigned');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->timestamp('due_date');
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('housekeeping_tasks');
    }
};