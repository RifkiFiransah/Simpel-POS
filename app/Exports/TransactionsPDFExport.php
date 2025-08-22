<?php

namespace App\Exports;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionsPDFExport
{
    protected $dateFrom;
    protected $dateTo;

    public function __construct($dateFrom = null, $dateTo = null)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function download()
    {
        $query = Transaction::with(['customer', 'user', 'items.product'])
            ->orderBy('created_at', 'desc');

        if ($this->dateFrom && $this->dateTo) {
            $query->whereBetween('created_at', [$this->dateFrom, $this->dateTo]);
        }

        $transactions = $query->get();
        
        // Calculate summary
        $summary = [
            'total_transactions' => $transactions->count(),
            'total_revenue' => $transactions->sum('total'),
            'total_items' => $transactions->sum(function($transaction) {
                return $transaction->items->sum('quantity');
            }),
            'payment_methods' => $transactions->groupBy('method')->map->count(),
            'period' => $this->dateFrom && $this->dateTo 
                ? $this->dateFrom . ' - ' . $this->dateTo 
                : 'Semua Data'
        ];

        $pdf = Pdf::loadView('reports.transactions-pdf', compact('transactions', 'summary'));
        $pdf->setPaper('A4', 'landscape');
        
        $filename = 'laporan-transaksi-' . now()->format('Y-m-d-H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }
}
