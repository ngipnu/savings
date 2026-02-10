<?php

namespace App\Livewire\Admin;

use App\Models\Transaction;
use App\Models\User;
use App\Models\SavingType;
use App\Imports\TransactionsImport;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class TransactionManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $showModal = false;
    public $showImportModal = false;
    public $editMode = false;
    public $importFile;
    public $transactionId;
    public $user_id;
    public $saving_type_id;
    public $type;
    public $amount;
    public $date;
    public $description;
    public $status = 'pending';
    
    public $search = '';
    public $studentSearch = '';
    public $filterType = '';
    public $filterStatus = '';

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'saving_type_id' => 'required|exists:saving_types,id',
        'type' => 'required|in:deposit,withdrawal',
        'amount' => 'required|numeric|min:0',
        'date' => 'required|date',
        'description' => 'nullable|string',
        'status' => 'required|in:pending,approved,rejected',
    ];

    public function render()
    {
        $transactions = Transaction::with(['user', 'savingType'])
            ->when($this->search, function($query) {
                $query->whereHas('user', function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('student_id', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterType, function($query) {
                $query->where('type', $this->filterType);
            })
            ->when($this->filterStatus, function($query) {
                $query->where('status', $this->filterStatus);
            })
            ->latest()
            ->paginate(15);

        $students = User::where('role', 'student')->get();
        $savingTypes = SavingType::all();
        $classes = \App\Models\ClassRoom::all();

        return view('livewire.admin.transaction-management', [
            'transactions' => $transactions,
            'students' => $students,
            'savingTypes' => $savingTypes,
            'classes' => $classes,
        ])->layout('components.layouts.admin', ['title' => 'Manajemen Transaksi']);
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
        $this->editMode = false;
        $this->transactionId = null;
        $this->user_id = null;
        $this->saving_type_id = null;
        $this->type = '';
        $this->amount = '';
        $this->date = now()->format('Y-m-d');
        $this->description = '';
        $this->status = 'pending';
        $this->studentSearch = ''; 
        $this->dispatch('transaction-saved');
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        if (auth()->user()->role === 'operator') {
            $this->status = 'pending';
        }

        if ($this->editMode) {
            $transaction = Transaction::findOrFail($this->transactionId);
            $transaction->update([
                'user_id' => $this->user_id,
                'saving_type_id' => $this->saving_type_id,
                'type' => $this->type,
                'amount' => $this->amount,
                'date' => $this->date,
                'description' => $this->description,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Transaksi berhasil diperbarui!');
        } else {
            Transaction::create([
                'user_id' => $this->user_id,
                'saving_type_id' => $this->saving_type_id,
                'type' => $this->type,
                'amount' => $this->amount,
                'date' => $this->date,
                'description' => $this->description,
                'status' => $this->status,
            ]);
            session()->flash('message', 'Transaksi berhasil ditambahkan!');
        }

        $this->closeModal();
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $this->editMode = true;
        $this->transactionId = $transaction->id;
        $this->user_id = $transaction->user_id;
        $this->saving_type_id = $transaction->saving_type_id;
        $this->type = $transaction->type;
        $this->amount = $transaction->amount;
        $this->date = $transaction->date;
        $this->description = $transaction->description;
        $this->status = $transaction->status;
        $this->showModal = true;
        $this->dispatch('set-student-choice', userId: $this->user_id);
    }

    public function approve($id)
    {
        if (auth()->user()->role !== 'super_admin') {
            return;
        }
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'approved']);
        session()->flash('message', 'Transaksi berhasil disetujui!');
    }

    public function reject($id)
    {
        if (auth()->user()->role !== 'super_admin') {
            return;
        }
        $transaction = Transaction::findOrFail($id);
        $transaction->update(['status' => 'rejected']);
        session()->flash('message', 'Transaksi ditolak!');
    }

    public function delete($id)
    {
        Transaction::findOrFail($id)->delete();
        session()->flash('message', 'Transaksi berhasil dihapus!');
    }

    public function approveAll()
    {
        if (auth()->user()->role !== 'super_admin') {
            return;
        }
        $count = Transaction::where('status', 'pending')->count();
        
        if ($count > 0) {
            Transaction::where('status', 'pending')->update(['status' => 'approved']);
            session()->flash('message', "$count transaksi berhasil disetujui sekaligus!");
        } else {
            session()->flash('message', 'Tidak ada transaksi pending untuk disetujui.');
        }
    }


    public function openImportModal()
    {
        $this->showImportModal = true;
        $this->importFile = null;
    }

    public function closeImportModal()
    {
        $this->showImportModal = false;
        $this->importFile = null;
    }

    public function import()
    {
        $this->validate([
            'importFile' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new TransactionsImport, $this->importFile->getRealPath());
            session()->flash('message', 'Data transaksi berhasil diimport!');
            $this->closeImportModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }
}
