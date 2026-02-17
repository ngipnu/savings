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

    // Transaction form properties
    public $showModal = false;
    public $saving_type_id;
    public $type;
    public $amount;
    public $date;
    public $description;
    public $status = 'pending';

    protected function rules()
    {
        return [
            'saving_type_id' => 'required|exists:saving_types,id',
            'type' => 'required|in:deposit,withdrawal',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
        ];
    }

    protected $validationAttributes = [
        'saving_type_id' => 'produk tabungan',
        'type' => 'tipe',
        'amount' => 'jumlah',
        'date' => 'tanggal',
        'status' => 'status',
    ];

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

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->saving_type_id = null;
        $this->type = '';
        $this->amount = '';
        $this->date = now()->format('Y-m-d');
        $this->description = '';
        $this->status = 'pending';
        $this->resetErrorBag();
    }

    public function saveTransaction()
    {
        $this->validate();

        if (in_array(auth()->user()->role, ['operator', 'wali_kelas'])) {
            $this->status = 'pending';
        }

        \App\Models\Transaction::create([
            'user_id' => $this->student->id,
            'saving_type_id' => $this->saving_type_id,
            'type' => $this->type,
            'amount' => $this->amount,
            'date' => $this->date,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        session()->flash('message', 'Transaksi berhasil ditambahkan!');
        
        $this->calculateTotals();
        $this->closeModal();
    }

    public function render()
    {
        $transactions = \App\Models\Transaction::with('savingType', 'approver')
            ->where('user_id', $this->student->id)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $savingTypes = \App\Models\SavingType::all();

        return view('livewire.admin.student-recap', [
            'transactions' => $transactions,
            'savingTypes' => $savingTypes
        ])->layout('components.layouts.admin', ['title' => 'Rekap Tabungan - ' . $this->student->name]);
    }
}
