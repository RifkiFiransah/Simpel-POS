<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuppliersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Supplier::withCount('purchases')
            ->orderBy('name')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Supplier',
            'Email',
            'Telepon',
            'Alamat',
            'Total Purchase',
            'Tanggal Daftar',
            'Status',
        ];
    }

    public function map($supplier): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $supplier->name,
            $supplier->email ?? '-',
            $supplier->phone ?? '-',
            $supplier->address ?? '-',
            $supplier->purchases_count ?? 0,
            $supplier->created_at->format('d/m/Y H:i'),
            'Aktif',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '3B82F6']],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 25,
            'D' => 15,
            'E' => 30,
            'F' => 15,
            'G' => 18,
            'H' => 10,
        ];
    }
}
