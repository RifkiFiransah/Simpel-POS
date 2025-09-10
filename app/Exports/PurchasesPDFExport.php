<?php 

namespace App\Exports;

use App\Models\Purchase;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchasesPDFExport
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
        $query = Purchase::with(['supplier', 'user', 'items.product'])
            ->orderBy('created_at', 'desc');

        if ($this->dateFrom && $this->dateTo) {
            $query->whereBetween('created_at', [$this->dateFrom, $this->dateTo]);
        }

        $purchases = $query->get();
        
        // Calculate summary
        $summary = [
            'total_purchases' => $purchases->count(),
            'total_spent' => $purchases->sum('total'),
            'total_items' => $purchases->sum(function($purchase) {
                return $purchase->items->sum('quantity');
            }),
            'payment_methods' => $purchases->groupBy('method')->map->count(),
            'period' => $this->dateFrom && $this->dateTo 
                ? $this->dateFrom . ' - ' . $this->dateTo 
                : 'Semua Data'
        ];

        $pdf = Pdf::loadView('reports.purchases-pdf', compact('purchases', 'summary'));
        $pdf->setPaper('A4', 'landscape');
        
        $filename = 'laporan-pembelian-' . now()->format('Y-m-d-H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }
}
?>