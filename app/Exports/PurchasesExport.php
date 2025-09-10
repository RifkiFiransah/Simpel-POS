<?php 

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PurchasesExport implements FromCollection, WithHeadings, WithMapping
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
        $query = Purchase::with(['supplier:id,name', 'user:id,name'])
            ->orderBy('created_at', 'desc')
            ->limit(500); // Limit untuk mencegah memory issue

        // Filter by invoice number (single purchase)
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
            'Supplier',
            'Kasir',
            'Total',
            'Metode Pembayaran',
            'Pembayaran',
            'Kembalian'
        ];
    }

    /**
     * @param Purchase $purchase
     * @return array
     */
    public function map($purchase): array
    {
        return [
            $purchase->invoice_number,
            $purchase->created_at->format('Y-m-d H:i:s'),
            $purchase->supplier ? $purchase->supplier->name : 'Umum',
            $purchase->user ? $purchase->user->name : 'System',
            number_format($purchase->total_amount, 0, ',', '.'),
            ucfirst(str_replace('_', ' ', $purchase->payment_method)),
            number_format($purchase->payment_amount, 0, ',', '.'),
            number_format($purchase->change_amount, 0, ',', '.'),
        ];
    }
}
?>