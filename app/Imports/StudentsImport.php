<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new User([
            'name' => $row['nama'],
            'email' => $row['email'],
            'password' => Hash::make($row['password'] ?? 'password'),
            'student_id' => $row['nis'],
            'class_room_id' => $row['class_room_id'] ?? null,
            'phone' => $row['no_hp'] ?? null,
            'address' => $row['alamat'] ?? null,
            'parent_name' => $row['nama_orang_tua'] ?? null,
            'parent_phone' => $row['no_hp_orang_tua'] ?? null,
            'parent_email' => $row['email_orang_tua'] ?? null,
            'role' => 'student',
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'nis' => 'required|unique:users,student_id',
        ];
    }
}
