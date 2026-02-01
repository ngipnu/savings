<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SavingType;
use App\Models\Transaction;
use App\Models\ClassRoom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Classes
        $classA = ClassRoom::firstOrCreate(['name' => 'X-RPL-1']);
        $classB = ClassRoom::firstOrCreate(['name' => 'XI-TKJ-2']);

        // 2. Create Users
        $admin = User::updateOrCreate([
            'email' => 'admin@admin.com'
        ], [
            'name' => 'Administrator',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);

        $wali = User::updateOrCreate([
            'email' => 'wali@guru.com'
        ], [
            'name' => 'Budi Santoso (Wali Kelas)',
            'password' => Hash::make('password'),
            'role' => 'wali_kelas',
            'phone' => '081234567890'
        ]);
        
        // Assign wali to class A
        $classA->update(['teacher_id' => $wali->id]);

        $operator = User::updateOrCreate([
            'email' => 'operator@staff.com'
        ], [
            'name' => 'Mba Admin (Operator)',
            'password' => Hash::make('password'),
            'role' => 'operator',
        ]);

        $student = User::updateOrCreate([
            'email' => 'student@student.com'
        ], [
            'name' => 'Ahmad Siswa',
            'password' => Hash::make('password'),
            'role' => 'student',
            'student_id' => '2024001',
            'class_name' => 'X-RPL-1', // Legacy
            'class_room_id' => $classA->id,
            'phone' => '08987654321',
            'address' => 'Jl. Merdeka No. 1'
        ]);

        // 3. Create Saving Types
        $wajib = SavingType::firstOrCreate(['name' => 'Tabungan Wajib'], ['description' => 'Tabungan wajib bulanan', 'min_amount' => 50000]);
        $sukarela = SavingType::firstOrCreate(['name' => 'Tabungan Sukarela'], ['description' => 'Tabungan bebas nominal', 'min_amount' => 5000]);
        $tour = SavingType::firstOrCreate(['name' => 'Tabungan Study Tour'], ['description' => 'Khusus kelas XI', 'min_amount' => 100000]);

        // 4. Create Transactions (Use updateOrCreate for idempotency)
        // Deposit
        Transaction::updateOrCreate([
            'user_id' => $student->id,
            'amount' => 50000,
            'date' => Carbon::now()->subDays(5)->format('Y-m-d'),
        ], [
            'saving_type_id' => $wajib->id,
            'type' => 'deposit',
            'status' => 'approved',
            'description' => 'Setoran awal bulan'
        ]);

        Transaction::updateOrCreate([
            'user_id' => $student->id,
            'amount' => 20000,
            'date' => Carbon::now()->subDays(3)->format('Y-m-d'),
        ], [
            'saving_type_id' => $sukarela->id,
            'type' => 'deposit',
            'status' => 'approved',
            'description' => 'Sisa uang jajan'
        ]);

        // Withdrawal
        Transaction::updateOrCreate([
            'user_id' => $student->id,
            'amount' => 10000,
            'date' => Carbon::now()->subDay()->format('Y-m-d'),
        ], [
            'saving_type_id' => $sukarela->id,
            'type' => 'withdrawal',
            'status' => 'approved', // Or pending
            'description' => 'Beli buku'
        ]);
        
        // Pending Transaction
        Transaction::updateOrCreate([
            'user_id' => $student->id,
            'amount' => 15000,
            'date' => Carbon::now()->format('Y-m-d'),
        ], [
             'saving_type_id' => $sukarela->id,
             'type' => 'deposit',
             'status' => 'pending',
             'description' => 'Setoran baru'
        ]);
    }
}
