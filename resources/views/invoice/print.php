<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $transaction->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }
        
        .company-info {
            font-size: 12px;
            color: #666;
        }
        
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .invoice-details, .customer-details {
            flex: 1;
        }
        
        .invoice-details {
            text-align: right;
        }
        
        .invoice-number {
            font-size: 18px;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 10px;
        }
        
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .details-table th,
        .details-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        
        .details-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        
        .details-table .text-right {
            text-align: right;
        }
        
        .details-table .text-center {
            text-align: center;
        }
        
        .summary {
            margin-top: 20px;
            text-align: right;
        }
        
        .summary-table {
            margin-left: auto;
            border-collapse: collapse;
            min-width: 300px;
        }
        
        .summary-table td {
            padding: 8px 15px;
            border-bottom: 1px solid #eee;
        }
        
        .summary-table .label {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        
        .total-row {
            font-size: 18px;
            font-weight: bold;
            background-color: #2563eb !important;
            color: white !important;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .payment-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .badge-cash { background-color: #10b981; color: white; }
        .badge-transfer { background-color: #3b82f6; color: white; }
        .badge-qris { background-color: #f59e0b; color: white; }
        .badge-debit { background-color: #6366f1; color: white; }
        
        @media print {
            body { margin: 0; }
            .invoice-container { box-shadow: none; }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="company-name">Simple POS</div>
            <div class="company-info">
                Point of Sale System<br>
                Jl. Contoh No. 123, Kota, Indonesia<br>
                Phone: (021) 1234-5678 | Email: info@simplepos.com
            </div>
        </div>

        <!-- Invoice Info -->
        <div class="invoice-info">
            <div class="customer-details">
                <h3>Bill To:</h3>
                <strong>{{ $transaction->customer?->name ?? 'Walk-in Customer' }}</strong><br>
                @if($transaction->customer)
                    {{ $transaction->customer->email ?? '' }}<br>
                    {{ $transaction->customer->phone ?? '' }}<br>
                    {{ $transaction->customer->address ?? '' }}
                @endif
            </div>
            
            <div class="invoice-details">
                <div class="invoice-number">{{ $transaction->invoice_number }}</div>
                <strong>Date:</strong> {{ $transaction->created_at->format('d M Y H:i') }}<br>
                <strong>Cashier:</strong> {{ $transaction->user->name }}<br>
                <strong>Payment Method:</strong> 
                <span class="badge badge-{{ $transaction->method }}">{{ ucfirst($transaction->method) }}</span>
            </div>
        </div>

        <!-- Items Table -->
        <table class="details-table">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Product</th>
                    <th class="text-center" style="width: 80px;">Qty</th>
                    <th class="text-right" style="width: 120px;">Price</th>
                    <th class="text-right" style="width: 120px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->product->name }}</strong><br>
                        <small style="color: #666;">{{ $item->product->code }}</small>
                    </td>
                    <td class="text-center">{{ number_format($item->quantity) }}</td>
                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Payment Summary -->
        <div class="payment-info">
            <strong>Payment Information:</strong><br>
            Method: {{ ucfirst($transaction->method) }} | 
            Payment: Rp {{ number_format($transaction->payment, 0, ',', '.') }} | 
            Change: Rp {{ number_format($transaction->change, 0, ',', '.') }}
        </div>

        <!-- Summary -->
        <div class="summary">
            <table class="summary-table">
                <tr>
                    <td class="label">Total Items:</td>
                    <td>{{ $transaction->items->sum('quantity') }} pcs</td>
                </tr>
                <tr>
                    <td class="label">Subtotal:</td>
                    <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="label">Tax (0%):</td>
                    <td>Rp 0</td>
                </tr>
                <tr class="total-row">
                    <td class="label">Grand Total:</td>
                    <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>This is a computer generated invoice and does not require signature.</p>
            <p>For any questions regarding this invoice, please contact us.</p>
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
