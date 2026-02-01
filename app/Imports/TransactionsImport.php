<?php

namespace App\Imports;

use App\Models\Transaction;
use App\Models\User;
use App\Models\SavingType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TransactionsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Find user by student_id
        $user = User::where('student_id', $row['nis'])->first();
        
        // Find saving type by name
        $savingType = SavingType::where('name', $row['jenis_tabungan'])->first();
        
        if (!$user || !$savingType) {
            return null;
        }

        return new Transaction([
            'user_id' => $user->id,
            'saving_type_id' => $savingType->id,
            'type' => strtolower($row['tipe']) === 'setoran' ? 'deposit' : 'withdrawal',
            'amount' => $row['jumlah'],
            'date' => \Carbon\Carbon::parse($row['tanggal'])->format('Y-m-d'),
            'description' => $row['keterangan'] ?? null,
            'status' => $row['status'] ?? 'approved',
        ]);
    }

    public function rules(): array
    {
        return [
            'nis' => 'required',
            'jenis_tabungan' => 'required',
            'tipe' => 'required|in:setoran,penarikan,Setoran,Penarikan',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ];
    }
}
