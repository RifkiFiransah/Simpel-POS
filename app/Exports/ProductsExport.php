<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Product::with(['category'])
            ->orderBy('name')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Produk',
            'SKU',
            'Kategori',
            'Harga Beli',
            'Harga Jual',
            'Stok',
            'Deskripsi',
            'Status',
            'Tanggal Dibuat',
        ];
    }

    public function map($product): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $product->name,
            $product->sku ?? '-',
            $product->category->name ?? '-',
            'Rp ' . number_format($product->purchase_price ?? 0, 0, ',', '.'),
            'Rp ' . number_format($product->selling_price ?? 0, 0, ',', '.'),
            $product->stock ?? 0,
            $product->description ?? '-',
            $product->is_active ? 'Aktif' : 'Tidak Aktif',
            $product->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '4F46E5']],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 15,
            'D' => 20,
            'E' => 15,
            'F' => 15,
            'G' => 10,
            'H' => 30,
            'I' => 12,
            'J' => 18,
        ];
    }
}
