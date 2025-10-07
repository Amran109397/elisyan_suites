// database/seeders/PaymentSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\PaymentGateway;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        $bookings = Booking::all();
        
        // Create payment gateways
        $paymentGateways = [
            [
                'name' => 'Stripe',
                'config' => json_encode(['api_key' => 'pk_test_1234567890']),
                'is_active' => true,
            ],
            [
                'name' => 'PayPal',
                'config' => json_encode(['client_id' => 'test_client_id', 'secret' => 'test_secret']),
                'is_active' => true,
            ],
            [
                'name' => 'Bank Transfer',
                'config' => json_encode(['account_number' => '1234567890', 'bank_name' => 'Test Bank']),
                'is_active' => true,
            ],
        ];

        foreach ($paymentGateways as $gateway) {
            PaymentGateway::create($gateway);
        }

        $gateways = PaymentGateway::all();
        
        $paymentMethods = ['credit_card', 'debit_card', 'cash', 'mobile_banking', 'bank_transfer', 'voucher'];
        $paymentTypes = ['advance', 'partial', 'full', 'refund', 'deposit'];
        $paymentStatuses = ['pending', 'completed', 'failed', 'refunded'];
        
        // Create payments for each booking
        foreach ($bookings as $booking) {
            // Skip cancelled bookings
            if ($booking->status == 'cancelled') {
                continue;
            }
            
            // Number of payments (1-3)
            $numPayments = rand(1, 3);
            
            // Calculate payment amounts
            $totalAmount = $booking->total_price;
            $paidAmount = 0;
            
            for ($i = 0; $i < $numPayments; $i++) {
                $isLastPayment = ($i == $numPayments - 1);
                
                if ($isLastPayment) {
                    $amount = $totalAmount - $paidAmount;
                    $paymentType = 'full';
                } else {
                    // Partial payment (20-50% of total)
                    $percentage = rand(20, 50) / 100;
                    $amount = round($totalAmount * $percentage, 2);
                    $paymentType = 'partial';
                    $paidAmount += $amount;
                }
                
                $payment = [
                    'booking_id' => $booking->id,
                    'guest_id' => $booking->guest_id,
                    'payment_gateway_id' => $gateways->random()->id,
                    'amount' => $amount,
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'payment_type' => $paymentType,
                    'payment_status' => 'completed',
                    'transaction_id' => 'TXN' . time() . rand(1000, 9999),
                    'remarks' => $i % 2 == 0 ? 'Payment received' : null,
                ];
                
                $paymentModel = Payment::create($payment);
                
                // Set paid_at date for completed payments
                if ($payment['payment_status'] == 'completed') {
                    $paymentModel->paid_at = Carbon::now()->subDays(rand(0, 30));
                    $paymentModel->save();
                }
            }
        }
    }
}