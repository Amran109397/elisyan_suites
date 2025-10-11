<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('invoice_number')->unique();
            $table->date('issue_date');
            $table->date('due_date');
            $table->decimal('amount', 12, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->enum('status', ['draft', 'sent', 'paid', 'overdue', 'cancelled', 'voided'])->default('draft');
            $table->string('pdf_path')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};