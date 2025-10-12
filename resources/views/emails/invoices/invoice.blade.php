// resources/views/emails/invoices/invoice.blade.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .invoice-details table {
            width: 100%;
        }
        .invoice-details td {
            padding: 5px 0;
        }
        .invoice-details td:first-child {
            font-weight: bold;
            width: 150px;
        }
        .amount-summary {
            background: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .amount-summary table {
            width: 100%;
        }
        .amount-summary td {
            padding: 5px 0;
        }
        .amount-summary td:last-child {
            text-align: right;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Invoice #{{ $invoice->invoice_number }}</h1>
            <p>{{ $invoice->booking->property->name }}</p>
        </div>
        
        <div class="invoice-details">
            <table>
                <tr>
                    <td>Invoice Date:</td>
                    <td>{{ $invoice->issue_date }}</td>
                </tr>
                <tr>
                    <td>Due Date:</td>
                    <td>{{ $invoice->due_date }}</td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td>
                        <span style="background: {{ $invoice->status == 'paid' ? '#28a745' : ($invoice->status == 'sent' ? '#17a2b8' : '#ffc107') }}; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px;">
                            {{ strtoupper($invoice->status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Guest:</td>
                    <td>{{ $invoice->booking->guest->full_name }}</td>
                </tr>
                <tr>
                    <td>Booking Reference:</td>
                    <td>{{ $invoice->booking->booking_reference }}</td>
                </tr>
                <tr>
                    <td>Check-in:</td>
                    <td>{{ $invoice->booking->check_in_date }}</td>
                </tr>
                <tr>
                    <td>Check-out:</td>
                    <td>{{ $invoice->booking->check_out_date }}</td>
                </tr>
            </table>
        </div>
        
        <div class="amount-summary">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td>${{ number_format($invoice->amount - $invoice->tax_amount, 2) }}</td>
                </tr>
                <tr>
                    <td>Tax:</td>
                    <td>${{ number_format($invoice->tax_amount, 2) }}</td>
                </tr>
                <tr>
                    <td>Total Amount:</td>
                    <td>${{ number_format($invoice->amount, 2) }}</td>
                </tr>
                <tr>
                    <td>Paid Amount:</td>
                    <td>${{ number_format($invoice->paid_amount, 2) }}</td>
                </tr>
                <tr>
                    <td>Remaining Amount:</td>
                    <td>${{ number_format($invoice->remaining_amount, 2) }}</td>
                </tr>
            </table>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/invoices/' . $invoice->id) }}" class="btn">View Invoice Online</a>
        </div>
        
        <div class="footer">
            <p>This is an automated email from {{ $invoice->booking->property->name }}.</p>
            <p>If you have any questions, please contact our billing department.</p>
            <p>&copy; {{ date('Y') }} {{ $invoice->booking->property->name }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>