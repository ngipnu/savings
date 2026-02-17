<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;

class StudentRecap extends Component
{
    use WithPagination;

    public $student;
    public $perPage = 10;
    
    public $totalDeposit = 0;
    public $totalWithdrawal = 0;
    public $balance = 0;

    public function mount($id)
    {
        $user = auth()->user();
        
        $this->student = \App\Models\User::with('classRoom')
            ->where('role', 'student')
            ->findOrFail($id);
            
        // Restriction for Wali Kelas
        if ($user->role === 'wali_kelas' && $user->teachingClass->id != $this->student->class_room_id) {
            abort(403, 'Unauthorized access to this student recap.');
        }

        $this->calculateTotals();
    }
    
    public function calculateTotals()
    {
        $this->totalDeposit = \App\Models\Transaction::where('user_id', $this->student->id)
            ->where('type', 'deposit')
            ->whereIn('status', ['approved', 'pending'])
            ->sum('amount');
            
        $this->totalWithdrawal = \App\Models\Transaction::where('user_id', $this->student->id)
            ->where('type', 'withdrawal')
            ->whereIn('status', ['approved', 'pending'])
            ->sum('amount');
            
        $this->balance = $this->totalDeposit - $this->totalWithdrawal;
    }

    public function render()
    {
        $transactions = \App\Models\Transaction::with('savingType', 'approver')
            ->where('user_id', $this->student->id)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.student-recap', [
            'transactions' => $transactions
        ])->layout('components.layouts.admin', ['title' => 'Rekap Tabungan - ' . $this->student->name]);
    }
}
