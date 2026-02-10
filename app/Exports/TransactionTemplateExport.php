<?php

namespace App\Exports;

use App\Models\User;
use App\Models\SavingType;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionTemplateExport implements WithHeadings, WithTitle, WithStyles, FromArray, WithEvents
{
    protected $classId;

    public function __construct($classId = null)
    {
        $this->classId = $classId;
    }

    public function array(): array
    {
        if ($this->classId) {
            $students = User::where('class_room_id', $this->classId)
                ->with('classRoom')
                ->get();

            $data = [];
            foreach ($students as $student) {
                $data[] = [
                    $student->student_id,
                    $student->name,
                    $student->classRoom->name ?? '-',
                    '',               // Saving Type (Empty forced for user selection)
                    '',               // Type (Empty forced for user selection)
                    '',               // Amount
                    date('Y-m-d'),    // Date
                    '',               // Description
                    'approved'        // Status
                ];
            }
            return $data;
        }

        // Default example if no class selected
        return [
            [
                '2024001',
                'Siswa Contoh',
                'Kelas 1',
                'Tabungan Wajib',
                'setoran',
                '50000',
                '2024-02-01',
                'Setoran awal bulan',
                'approved'
            ],
            [
                '2024002',
                'Siswa Contoh 2',
                'Kelas 2',
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
            'nama',
            'kelas',
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $rowCount = 1000; // Define validation for up to 1000 rows
                $sheet = $event->sheet;

                // 1. Validation for Saving Type (Column D)
                $savingTypes = SavingType::pluck('name')->toArray();
                $savingTypeString = '"' . implode(',', $savingTypes) . '"';
                
                $validation = $sheet->getCell('D2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Input Error');
                $validation->setError('Value is not in list.');
                $validation->setPromptTitle('Pilih Jenis Tabungan');
                $validation->setPrompt('Silakan pilih jenis tabungan dari daftar.');
                $validation->setFormula1($savingTypeString);

                // Clone validation to remaining rows
                for ($i = 3; $i <= $rowCount; $i++) {
                    $sheet->getCell("D{$i}")->setDataValidation(clone $validation);
                }

                // 2. Validation for Transaction Type (Column E)
                $types = '"setoran,penarikan"';
                $validationType = $sheet->getCell('E2')->getDataValidation();
                $validationType->setType(DataValidation::TYPE_LIST);
                $validationType->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationType->setAllowBlank(false);
                $validationType->setShowInputMessage(true);
                $validationType->setShowErrorMessage(true);
                $validationType->setShowDropDown(true);
                $validationType->setErrorTitle('Input Error');
                $validationType->setError('Value is not in list.');
                $validationType->setPromptTitle('Pilih Tipe Transaksi');
                $validationType->setPrompt('Pilih setoran atau penarikan.');
                $validationType->setFormula1($types);

                for ($i = 3; $i <= $rowCount; $i++) {
                    $sheet->getCell("E{$i}")->setDataValidation(clone $validationType);
                }

                // 3. Validation for Status (Column I)
                $statuses = '"pending,approved,rejected"';
                $validationStatus = $sheet->getCell('I2')->getDataValidation();
                $validationStatus->setType(DataValidation::TYPE_LIST);
                $validationStatus->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validationStatus->setAllowBlank(false);
                $validationStatus->setShowInputMessage(true);
                $validationStatus->setShowErrorMessage(true);
                $validationStatus->setShowDropDown(true);
                $validationStatus->setFormula1($statuses);

                for ($i = 3; $i <= $rowCount; $i++) {
                    $sheet->getCell("I{$i}")->setDataValidation(clone $validationStatus);
                }
            },
        ];
    }
}
