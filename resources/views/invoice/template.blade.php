<!DOCTYPE html>
<html lang="id">
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
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .invoice {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
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
            width: 48%;
        }
        
        .invoice-details h3, .customer-details h3 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        
        .invoice-number {
            font-size: 16px;
            font-weight: bold;
            color: #2563eb;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .items-table th,
        .items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        .items-table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: center;
        }
        
        .items-table td.number {
            text-align: right;
        }
        
        .items-table td.center {
            text-align: center;
        }
        
        .total-section {
            margin-top: 20px;
            text-align: right;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            padding: 5px 0;
        }
        
        .total-row.grand-total {
            font-weight: bold;
            font-size: 16px;
            border-top: 2px solid #333;
            padding-top: 10px;
            color: #2563eb;
        }
        
        .payment-info {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        @media print {
            body {
                print-color-adjust: exact;
            }
            
            .invoice {
                max-width: none;
                margin: 0;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="invoice">
        <!-- Header -->
        <div class="header">
            <div class="company-name">Simple POS</div>
            <div class="company-info">
                Jl. Contoh No. 123, Kota, Provinsi 12345<br>
                Telp: (021) 1234-5678 | Email: info@simplepos.com
            </div>
        </div>

        <!-- Invoice Info -->
        <div class="invoice-info">
            <div class="invoice-details">
                <h3>Detail Invoice</h3>
                <div class="invoice-number">{{ $transaction->invoice_number }}</div>
                <div>Tanggal: {{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                <div>Kasir: {{ $transaction->user->name }}</div>
                <div>Metode: {{ ucfirst($transaction->method) }}</div>
            </div>
            
            <div class="customer-details">
                <h3>Detail Customer</h3>
                @if($transaction->customer)
                    <div><strong>{{ $transaction->customer->name }}</strong></div>
                    <div>{{ $transaction->customer->email }}</div>
                    <div>{{ $transaction->customer->phone }}</div>
                    <div>{{ $transaction->customer->address }}</div>
                @else
                    <div>Customer Umum</div>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 40%">Produk</th>
                    <th style="width: 15%">Harga</th>
                    <th style="width: 10%">Qty</th>
                    <th style="width: 15%">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->items as $index => $item)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td class="number">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="center">{{ $item->quantity }}</td>
                    <td class="number">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total Section -->
        <div class="total-section">
            <div style="width: 300px; margin-left: auto;">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                </div>
                <div class="total-row grand-total">
                    <span>Total:</span>
                    <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="payment-info">
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span><strong>Metode Pembayaran:</strong></span>
                <span>{{ ucfirst($transaction->method) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                <span><strong>Jumlah Bayar:</strong></span>
                <span>Rp {{ number_format($transaction->payment, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-weight: bold;">
                <span><strong>Kembalian:</strong></span>
                <span>Rp {{ number_format($transaction->change, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>Invoice ini dicetak secara otomatis pada {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
