<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .company-info {
            font-size: 12px;
        }
        .invoice-title {
            text-align: center;
            margin: 30px 0;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .invoice-info, .billing-info {
            width: 48%;
        }
        .info-row {
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        .section-title {
            font-weight: bold;
            margin: 20px 0 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-section {
            margin-top: 30px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .total-label {
            font-weight: bold;
        }
        .grand-total {
            font-size: 18px;
            font-weight: bold;
            border-top: 2px solid #333;
            padding-top: 10px;
            margin-top: 10px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }
        .status-draft { background-color: #6c757d; }
        .status-sent { background-color: #17a2b8; }
        .status-paid { background-color: #28a745; }
        .status-overdue { background-color: #dc3545; }
        .status-cancelled { background-color: #6c757d; }
        .status-voided { background-color: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">{{ $invoice->booking->property->name }}</div>
            <div class="company-info">
                {{ $invoice->booking->property->address }}, {{ $invoice->booking->property->city }}, {{ $invoice->booking->property->country }}<br>
                Phone: {{ $invoice->booking->property->phone }} | Email: {{ $invoice->booking->property->email }}
            </div>
            <a href="{{ route('invoices.download', $invoice->id) }}">Download PDF</a>
            <form action="{{ route('invoices.send', $invoice->id) }}" method="POST">
    @csrf
    <button type="submit">Send Invoice</button>
</form>
        </div>

        <!-- Invoice Title -->
        <div class="invoice-title">
            INVOICE
            <span class="status-badge status-{{ $invoice->status }}">{{ strtoupper($invoice->status) }}</span>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="invoice-info">
                <div class="info-row">
                    <span class="info-label">Invoice #:</span>
                    {{ $invoice->invoice_number }}
                </div>
                <div class="info-row">
                    <span class="info-label">Issue Date:</span>
                    {{ $invoice->issue_date }}
                </div>
                <div class="info-row">
                    <span class="info-label">Due Date:</span>
                    {{ $invoice->due_date }}
                </div>
                <div class="info-row">
                    <span class="info-label">Booking #:</span>
                    {{ $invoice->booking->booking_reference }}
                </div>
            </div>
            <div class="billing-info">
                <div class="info-row">
                    <span class="info-label">Guest:</span>
                    {{ $invoice->booking->guest->first_name }} {{ $invoice->booking->guest->last_name }}
                </div>
                <div class="info-row">
                    <span class="info-label">Address:</span>
                    {{ $invoice->booking->guest->address ?: 'N/A' }}
                </div>
                <div class="info-row">
                    <span class="info-label">Phone:</span>
                    {{ $invoice->booking->guest->phone ?: 'N/A' }}
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    {{ $invoice->booking->guest->email ?: 'N/A' }}
                </div>
            </div>
        </div>

        <!-- Booking Details -->
        <div class="section-title">Booking Details</div>
        <table class="table">
            <tr>
                <th width="20%">Property</th>
                <td>{{ $invoice->booking->property->name }}</td>
            </tr>
            <tr>
                <th>Room Type</th>
                <td>{{ $invoice->booking->roomType->name }}</td>
            </tr>
            <tr>
                <th>Room</th>
                <td>{{ $invoice->booking->room ? $invoice->booking->room->room_number : 'Not assigned' }}</td>
            </tr>
            <tr>
                <th>Check-in Date</th>
                <td>{{ $invoice->booking->check_in_date }}</td>
            </tr>
            <tr>
                <th>Check-out Date</th>
                <td>{{ $invoice->booking->check_out_date }}</td>
            </tr>
            <tr>
                <th>Total Nights</th>
                <td>{{ $invoice->booking->total_nights }}</td>
            </tr>
            <tr>
                <th>Guests</th>
                <td>{{ $invoice->booking->adults }} Adults, {{ $invoice->booking->children }} Children, {{ $invoice->booking->infants }} Infants</td>
            </tr>
        </table>

        <!-- Charges -->
        <div class="section-title">Charges</div>
        <table class="table">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="45%">Description</th>
                    <th width="15%">Qty</th>
                    <th width="15%">Unit Price</th>
                    <th width="20%">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Room Charge ({{ $invoice->booking->roomType->name }}) - {{ $invoice->booking->total_nights }} nights</td>
                    <td class="text-center">{{ $invoice->booking->total_nights }}</td>
                    <td class="text-right">{{ number_format($invoice->booking->roomType->base_price, 2) }}</td>
                    <td class="text-right">{{ number_format($invoice->booking->roomType->base_price * $invoice->booking->total_nights, 2) }}</td>
                </tr>
                
                <!-- Booking Add-ons -->
                @if($invoice->booking->addons->count() > 0)
                    @foreach($invoice->booking->addons as $index => $addon)
                        <tr>
                            <td>{{ $index + 2 }}</td>
                            <td>{{ $addon->addon->name }}</td>
                            <td class="text-center">{{ $addon->quantity }}</td>
                            <td class="text-right">{{ number_format($addon->price, 2) }}</td>
                            <td class="text-right">{{ number_format($addon->price * $addon->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                @endif
                
                <!-- Booking Services -->
                @if($invoice->booking->services->count() > 0)
                    @foreach($invoice->booking->services as $service)
                        <tr>
                            <td>{{ $loop->iteration + $invoice->booking->addons->count() + 1 }}</td>
                            <td>{{ $service->service->name }} ({{ $service->service_date ? $service->service_date->format('d M Y') : '' }})</td>
                            <td class="text-center">{{ $service->quantity }}</td>
                            <td class="text-right">{{ number_format($service->price, 2) }}</td>
                            <td class="text-right">{{ number_format($service->price * $service->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Payment Summary -->
        <div class="total-section">
            <div class="total-row">
                <div class="total-label">Subtotal:</div>
                <div class="text-right">{{ number_format($invoice->amount, 2) }}</div>
            </div>
            <div class="total-row">
                <div class="total-label">Tax:</div>
                <div class="text-right">{{ number_format($invoice->tax_amount, 2) }}</div>
            </div>
            <div class="total-row">
                <div class="total-label">Discount:</div>
                <div class="text-right">0.00</div>
            </div>
            <div class="total-row grand-total">
                <div class="total-label">TOTAL:</div>
                <div class="text-right">{{ number_format($invoice->amount + $invoice->tax_amount, 2) }}</div>
            </div>
        </div>

        <!-- Payments -->
        @if($invoice->payments->count() > 0)
            <div class="section-title">Payments</div>
            <table class="table">
                <thead>
                    <tr>
                        <th width="20%">Date</th>
                        <th width="25%">Method</th>
                        <th width="25%">Type</th>
                        <th width="15%">Status</th>
                        <th width="15%">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->payments as $payment)
                        <tr>
                            <td>{{ $payment->created_at->format('d M Y') }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}</td>
                            <td>
                                <span class="status-badge status-{{ $payment->payment_status }}">
                                    {{ ucfirst($payment->payment_status) }}
                                </span>
                            </td>
                            <td class="text-right">{{ number_format($payment->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="total-section">
                <div class="total-row">
                    <div class="total-label">Total Paid:</div>
                    <div class="text-right">{{ number_format($invoice->total_paid, 2) }}</div>
                </div>
                <div class="total-row">
                    <div class="total-label">Remaining:</div>
                    <div class="text-right">{{ number_format($invoice->remaining_amount, 2) }}</div>
                </div>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>For any inquiries, please contact us at {{ $invoice->booking->property->email }} or {{ $invoice->booking->property->phone }}</p>
            <p>{{ $invoice->booking->property->name }} | {{ $invoice->booking->property->address }}</p>
        </div>
    </div>
</body>
</html>