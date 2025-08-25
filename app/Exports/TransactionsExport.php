<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithProperties, WithTitle
{
    protected $dateFrom;
    protected $dateTo;

    public function __construct($dateFrom = null, $dateTo = null)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Transaction::with(['customer:id,name', 'user:id,name'])
            ->withCount('items')
            ->orderBy('created_at', 'desc')
            ->limit(500); // Limit untuk mencegah memory issue

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
            'Jumlah Item',
            'Total',
            'Metode Pembayaran',
            'Pembayaran',
            'Kembalian',
            'Detail Produk',
            'Status'
        ];
    }

    /**
     * @param Transaction $transaction
     */
    public function map($transaction): array
    {
        // Get items detail dengan query terpisah untuk mencegah memory issue
        $itemsDetail = '';
        if ($transaction->items_count > 0) {
            $items = $transaction->items()->with('product:id,name')->get();
            $itemsDetail = $items->map(function ($item) {
                return $item->product->name . ' (Qty: ' . $item->quantity . ', @Rp' . number_format($item->price, 0, ',', '.') . ')';
            })->implode('; ');
        }

        return [
            $transaction->invoice_number,
            $transaction->created_at->format('d/m/Y H:i'),
            $transaction->customer?->name ?? 'Walk-in Customer',
            $transaction->user->name,
            $transaction->items_count,
            'Rp ' . number_format($transaction->total, 0, ',', '.'),
            ucfirst($transaction->method),
            'Rp ' . number_format($transaction->payment, 0, ',', '.'),
            'Rp ' . number_format($transaction->change, 0, ',', '.'),
            $itemsDetail,
            'Selesai'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ]
            ],
            
            // Style for data rows
            'A:K' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => 'CCCCCC'],
                    ],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Invoice Number
            'B' => 18, // Date
            'C' => 20, // Customer
            'D' => 15, // Cashier
            'E' => 12, // Items Count
            'F' => 15, // Total
            'G' => 18, // Payment Method
            'H' => 15, // Payment
            'I' => 15, // Change
            'J' => 50, // Product Details
            'K' => 12, // Status
        ];
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Simple POS',
            'lastModifiedBy' => 'Simple POS',
            'title'          => 'Laporan Transaksi',
            'description'    => 'Data transaksi penjualan dari Simple POS',
            'subject'        => 'Laporan Transaksi',
            'keywords'       => 'transaksi,penjualan,laporan,pos',
            'category'       => 'Laporan',
            'manager'        => 'Admin',
            'company'        => 'Simple POS',
        ];
    }

    public function title(): string
    {
        return 'Transaksi';
    }
}
