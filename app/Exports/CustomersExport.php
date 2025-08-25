<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Customer::withCount('transaction')
            ->orderBy('name')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Customer',
            'Email',
            'Telepon',
            'Alamat',
            'Total Transaksi',
            'Tanggal Daftar',
            'Status',
        ];
    }

    public function map($customer): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $customer->name,
            $customer->email ?? '-',
            $customer->phone ?? '-',
            $customer->address ?? '-',
            $customer->transaction_count ?? 0,
            $customer->created_at->format('d/m/Y H:i'),
            'Aktif',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '10B981']],
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
