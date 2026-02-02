<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class AccountPrint extends Component
{
    public $student;

    public function mount($id)
    {
        $this->student = User::with('classRoom')->where('role', 'student')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.account-print')
            ->layout('components.layouts.app', ['title' => 'Cetak Akun Siswa']);
    }
}
