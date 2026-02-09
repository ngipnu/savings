<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class BulkAccountPrint extends Component
{
    public $students;

    public function mount($ids)
    {
        $this->students = User::with('classRoom')
            ->where('role', 'student')
            ->whereIn('id', explode(',', $ids))
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.bulk-account-print')
            ->layout('components.layouts.app', ['title' => 'Cetak Akun Siswa Massal']);
    }
}
