<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice {{ $transaction->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: monospace;
            font-size: 12px;
            line-height: 1.2;
            color: #000;
            width: 80mm;
            margin: 0 auto;
        }
        
        .receipt {
            padding: 10px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        
        .company-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .company-info {
            font-size: 10px;
        }
        
        .invoice-info {
            margin-bottom: 15px;
            font-size: 11px;
        }
        
        .invoice-info div {
            margin-bottom: 2px;
        }
        
        .items {
            margin-bottom: 15px;
        }
        
        .item {
            margin-bottom: 8px;
            border-bottom: 1px dotted #ccc;
            padding-bottom: 5px;
        }
        
        .item-name {
            font-weight: bold;
            margin-bottom: 2px;
        }
        
        .item-details {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
        }
        
        .totals {
            border-top: 1px dashed #000;
            padding-top: 10px;
            margin-bottom: 15px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        
        .total-row.grand-total {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-top: 5px;
        }
        
        .payment-section {
            border-top: 1px dashed #000;
            padding-top: 10px;
            margin-bottom: 15px;
        }
        
        .footer {
            text-align: center;
            font-size: 10px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }
        
        @media print {
            body {
                width: auto;
            }
            
            .receipt {
                padding: 5px;
            }
            
            @page {
                size: 80mm auto;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <div class="company-name">SIMPLE POS</div>
            <div class="company-info">
                Jl. Contoh No. 123<br>
                Telp: (021) 1234-5678
            </div>
        </div>

        <!-- Invoice Info -->
        <div class="invoice-info">
            <div>Invoice: {{ $transaction->invoice_number }}</div>
            <div>Tanggal: {{ $transaction->created_at->format('d/m/Y H:i') }}</div>
            <div>Kasir: {{ $transaction->user->name }}</div>
            @if($transaction->customer)
            <div>Customer: {{ $transaction->customer->name }}</div>
            @endif
        </div>

        <!-- Items -->
        <div class="items">
            @foreach($transaction->items as $item)
            <div class="item">
                <div class="item-name">{{ $item->product->name }}</div>
                <div class="item-details">
                    <span>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Totals -->
        <div class="totals">
            <div class="total-row grand-total">
                <span>TOTAL:</span>
                <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Payment -->
        <div class="payment-section">
            <div class="total-row">
                <span>Metode:</span>
                <span>{{ ucfirst($transaction->method) }}</span>
            </div>
            <div class="total-row">
                <span>Bayar:</span>
                <span>Rp {{ number_format($transaction->payment, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Kembali:</span>
                <span>Rp {{ number_format($transaction->change, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima Kasih!</p>
            <p>{{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
