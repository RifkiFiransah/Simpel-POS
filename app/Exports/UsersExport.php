<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return User::orderBy('name')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama User',
            'Email',
            'Role',
            'Email Verified',
            'Tanggal Daftar',
            'Last Login',
            'Status',
        ];
    }

    public function map($user): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $user->name,
            $user->email,
            'Admin', // Default role
            $user->email_verified_at ? 'Ya' : 'Tidak',
            $user->created_at->format('d/m/Y H:i'),
            $user->updated_at->format('d/m/Y H:i'),
            'Aktif',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '8B5CF6']],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 25,
            'D' => 12,
            'E' => 15,
            'F' => 18,
            'G' => 18,
            'H' => 10,
        ];
    }
}
