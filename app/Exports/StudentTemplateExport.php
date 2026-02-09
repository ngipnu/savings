<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentTemplateExport implements WithHeadings, WithTitle, WithStyles, FromArray
{
    public function array(): array
    {
        return [
            [
                'Ahmad Siswa',
                'ahmad@contoh.com',
                '2024001',
                'password123',
                '1',
                '08123456789',
                'Jl. Contoh No. 1',
                'Budi Orang Tua',
                '08198765432',
                'budi@orangtua.com'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'nama',
            'email',
            'nis',
            'password',
            'class_room_id',
            'no_hp',
            'alamat',
            'nama_orang_tua',
            'no_hp_orang_tua',
            'email_orang_tua'
        ];
    }

    public function title(): string
    {
        return 'Template Import Siswa';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
