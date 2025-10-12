// resources/views/backend/invoices/pdf.blade.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .company-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-details td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .invoice-details td:first-child {
            font-weight: bold;
            width: 150px;
            background: #f8f9fa;
        }
        .billing-items {
            margin-bottom: 30px;
        }
        .billing-items table {
            width: 100%;
            border-collapse: collapse;
        }
        .billing-items th,
        .billing-items td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .billing-items th {
            background: #f8f9fa;
            font-weight: bold;
        }
        .billing-items td:last-child {
            text-align: right;
        }
        .amount-summary {
            width: 300px;
            margin-left: auto;
        }
        .amount-summary table {
            width: 100%;
            border-collapse: collapse;
        }
        .amount-summary td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .amount-summary td:last-child {
            text-align: right;
            font-weight: bold;
        }
        .total-row td {
            background: #f8f9fa;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .status-badge {
            padding: 3px 8px;
            border-radius: 3px;
            color: white;
            font-size: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="company-info">
                <h2>{{ $property->name }}</h2>
                <p>{{ $property->address }}, {{ $property->city }}</p>
                <p>Phone: {{ $property->phone }} | Email: {{ $property->email }}</p>
            </div>
            <div class="invoice-title">INVOICE</div>
            <div style="font-size: 18px; font-weight: bold;">#{{ $invoice->invoice_number }}</div>
        </div>
        
        <div class="invoice-details">
            <table>
                <tr>
                    <td>Invoice Date</td>
                    <td>{{ $invoice->issue_date }}</td>
                    <td>Guest Name</td>
                    <td>{{ $guest->full_name }}</td>
                </tr>
                <tr>
                    <td>Due Date</td>
                    <td>{{ $invoice->due_date }}</td>
                    <td>Guest Email</td>
                    <td>{{ $guest->email }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <span class="status-badge" style="background: {{ $invoice->status == 'paid' ? '#28a745' : ($invoice->status == 'sent' ? '#17a2b8' : '#ffc107') }};">
                            {{ strtoupper($invoice->status) }}
                        </span>
                    </td>
                    <td>Booking Reference</td>
                    <td>{{ $booking->booking_reference }}</td>
                </tr>
                <tr>
                    <td>Check-in Date</td>
                    <td>{{ $booking->check_in_date }}</td>
                    <td>Check-out Date</td>
                    <td>{{ $booking->check_out_date }}</td>
                </tr>
            </table>
        </div>
        
        <div class="billing-items">
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Room Booking ({{ $booking->roomType->name }})</td>
                        <td>{{ $booking->total_nights }} nights</td>
                        <td>${{ number_format($booking->total_price / $booking->total_nights, 2) }}</td>
                        <td>${{ number_format($booking->total_price, 2) }}</td>
                    </tr>
                    
                    @foreach($booking->addons as $addon)
                    <tr>
                        <td>{{ $addon->addon->name }}</td>
                        <td>{{ $addon->quantity }}</td>
                        <td>${{ number_format($addon->price / $addon->quantity, 2) }}</td>
                        <td>${{ number_format($addon->price, 2) }}</td>
                    </tr>
                    @endforeach
                    
                    @foreach($booking->services as $service)
                    <tr>
                        <td>{{ $service->service->name }}</td>
                        <td>{{ $service->quantity }}</td>
                        <td>${{ number_format($service->price / $service->quantity, 2) }}</td>
                        <td>${{ number_format($service->price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="amount-summary">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td>${{ number_format($invoice->amount - $invoice->tax_amount, 2) }}</td>
                </tr>
                <tr>
                    <td>Tax ({{ number_format(($invoice->tax_amount / ($invoice->amount - $invoice->tax_amount)) * 100, 2) }}%)</td>
                    <td>${{ number_format($invoice->tax_amount, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>TOTAL</td>
                    <td>${{ number_format($invoice->amount, 2) }}</td>
                </tr>
                <tr>
                    <td>Paid Amount</td>
                    <td>${{ number_format($invoice->paid_amount, 2) }}</td>
                </tr>
                <tr>
                    <td>Remaining Amount</td>
                    <td>${{ number_format($invoice->remaining_amount, 2) }}</td>
                </tr>
            </table>
        </div>
        
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>For any questions regarding this invoice, please contact us at {{ $property->email }}</p>
            <p>Generated on {{ date('Y-m-d H:i:s') }}</p>
        </div>
    </div>
</body>
</html>