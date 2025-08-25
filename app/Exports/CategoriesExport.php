<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CategoriesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Category::withCount('products')
            ->orderBy('name')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Kategori',
            'Deskripsi',
            'Total Produk',
            'Tanggal Dibuat',
            'Terakhir Update',
            'Status',
        ];
    }

    public function map($category): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $category->name,
            $category->description ?? '-',
            $category->products_count ?? 0,
            $category->created_at->format('d/m/Y H:i'),
            $category->updated_at->format('d/m/Y H:i'),
            'Aktif',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['rgb' => 'F59E0B']],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 35,
            'D' => 15,
            'E' => 18,
            'F' => 18,
            'G' => 10,
        ];
    }
}
