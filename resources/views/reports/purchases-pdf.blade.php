<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }
        
        .report-title {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .report-period {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .report-date {
            font-size: 10px;
            color: #999;
        }
        
        .summary {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        
        .summary-row {
            display: table-row;
        }
        
        .summary-cell {
            display: table-cell;
            padding: 10px;
            border: 1px solid #dee2e6;
            text-align: center;
            font-weight: bold;
        }
        
        .summary-header {
            background-color: #2563eb;
            color: white;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 8px;
        }
        
        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        
        .data-table th {
            background-color: #2563eb;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        
        .data-table .text-right {
            text-align: right;
        }
        
        .data-table .text-center {
            text-align: center;
        }
        
        .data-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        .payment-method {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .method-cash { background-color: #10b981; color: white; }
        .method-transfer { background-color: #3b82f6; color: white; }
        .method-qris { background-color: #f59e0b; color: white; }
        .method-debit { background-color: #6366f1; color: white; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="company-name">Simple POS</div>
        <div class="report-title">LAPORAN TRANSAKSI PEMBELIAN</div>
        <div class="report-period">Periode: {{ $summary['period'] }}</div>
        <div class="report-date">Dicetak pada: {{ now()->format('d M Y H:i:s') }}</div>
    </div>

    <!-- Summary -->
    <div class="summary">
        <div class="summary-row">
            <div class="summary-cell summary-header">Total Transaksi</div>
            <div class="summary-cell summary-header">Total Pengeluaran</div>
            <div class="summary-cell summary-header">Total Item Terbeli</div>
            <div class="summary-cell summary-header">Metode Pembayaran</div>
        </div>
        <div class="summary-row">
            <div class="summary-cell">{{ number_format($summary['total_purchases']) }} transaksi</div>
            <div class="summary-cell">Rp {{ number_format($summary['total_spent'], 0, ',', '.') }}</div>
            <div class="summary-cell">{{ number_format($summary['total_items']) }} pcs</div>
            <div class="summary-cell">
                @foreach($summary['payment_methods'] as $method => $count)
                    <span class="payment-method method-{{ $method }}">{{ ucfirst($method) }}: {{ $count }}</span>
                    @if(!$loop->last) <br> @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="8%">No. Invoice</th>
                <th width="10%">Tanggal</th>
                <th width="12%">Supplier</th>
                <th width="10%">Admin</th>
                <th width="5%">Items</th>
                <th width="10%">Total</th>
                <th width="8%">Metode</th>
                <th width="10%">Pembayaran</th>
                <th width="10%">Kembalian</th>
                <th width="17%">Detail Produk</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchases as $purchase)
            <tr>
                <td class="text-center">{{ $purchase->invoice_number }}</td>
                <td class="text-center">{{ $purchase->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $purchase->supplier?->name ?? 'Walk-in Customer' }}</td>
                <td>{{ $purchase->user->name }}</td>
                <td class="text-center">{{ $purchase->items->sum('quantity') }}</td>
                <td class="text-right">Rp {{ number_format($purchase->total, 0, ',', '.') }}</td>
                <td class="text-center">
                    <span class="payment-method method-{{ $purchase->method }}">
                        {{ ucfirst($purchase->method) }}
                    </span>
                </td>
                <td class="text-right">Rp {{ number_format($purchase->payment, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($purchase->change, 0, ',', '.') }}</td>
                <td>
                    @foreach($purchase->items as $item)
                        {{ $item->product->name }} ({{ $item->quantity }}x)@if(!$loop->last), @endif
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Simple POS</strong> - Sistem Point of Sale</p>
        <p>Laporan ini dibuat secara otomatis oleh sistem | Halaman {PAGE_NUM} dari {PAGE_COUNT}</p>
        <p>Jl. Contoh No. 123, Kota, Indonesia | Phone: (021) 1234-5678 | Email: info@simplepos.com</p>
    </div>
</body>
</html>
