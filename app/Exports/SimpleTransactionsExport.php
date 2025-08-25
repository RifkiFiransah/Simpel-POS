<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SimpleTransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $dateFrom;
    protected $dateTo;
    protected $invoice;

    public function __construct($dateFrom = null, $dateTo = null, $invoice = null)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->invoice = $invoice;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Transaction::with(['customer:id,name', 'user:id,name'])
            ->orderBy('created_at', 'desc')
            ->limit(500); // Limit untuk mencegah memory issue

        // Filter by invoice number (single transaction)
        if ($this->invoice) {
            $query->where('invoice_number', $this->invoice)->limit(1);
        }
        
        // Filter by date range
        if ($this->dateFrom && $this->dateTo) {
            $query->whereBetween('created_at', [$this->dateFrom, $this->dateTo]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No. Invoice',
            'Tanggal',
            'Pelanggan',
            'Kasir',
            'Total',
            'Metode Pembayaran',
            'Pembayaran',
            'Kembalian'
        ];
    }

    /**
     * @param Transaction $transaction
     */
    public function map($transaction): array
    {
        return [
            $transaction->invoice_number,
            $transaction->created_at->format('d/m/Y H:i'),
            $transaction->customer?->name ?? 'Walk-in Customer',
            $transaction->user->name,
            'Rp ' . number_format($transaction->total, 0, ',', '.'),
            ucfirst($transaction->method),
            'Rp ' . number_format($transaction->payment, 0, ',', '.'),
            'Rp ' . number_format($transaction->change, 0, ',', '.')
        ];
    }
}
