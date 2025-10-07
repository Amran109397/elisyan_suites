// database/migrations/2023_10_01_000009_create_payments_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_id');
            $table->integer('guest_id');
            $table->integer('payment_gateway_id')->nullable();
            $table->decimal('amount', 12, 2);
            $table->enum('payment_method', ['credit_card', 'debit_card', 'cash', 'mobile_banking', 'bank_transfer', 'voucher']);
            $table->enum('payment_type', ['advance', 'partial', 'full', 'refund', 'deposit']);
            $table->enum('payment_status', ['pending', 'completed', 'failed', 'refunded', 'voided']);
            $table->string('transaction_id')->unique()->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('booking_id')->references('id')->on('bookings')->onDelete('cascade');
            $table->foreign('guest_id')->references('id')->on('guests')->onDelete('cascade');
            $table->foreign('payment_gateway_id')->references('id')->on('payment_gateways')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};