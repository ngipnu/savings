<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionTemplateExport implements WithHeadings, WithTitle, WithStyles, FromArray
{
    public function array(): array
    {
        return [
            [
                '2024001',
                'Tabungan Wajib',
                'setoran',
                '50000',
                '2024-02-01',
                'Setoran awal bulan',
                'approved'
            ],
            [
                '2024002',
                'Tabungan Sukarela',
                'penarikan',
                '10000',
                '2024-02-05',
                'Bayar buku pelajaran',
                'approved'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'nis',
            'jenis_tabungan',
            'tipe',
            'jumlah',
            'tanggal',
            'keterangan',
            'status'
        ];
    }

    public function title(): string
    {
        return 'Template Import Transaksi';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
