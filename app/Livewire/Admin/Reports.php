<?php

namespace App\Livewire\Admin;

use App\Models\Transaction;
use App\Models\BankDeposit;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Reports extends Component
{
    use WithPagination;

    public $showDepositModal = false;
    public $showWithdrawalModal = false;
    public $type = 'deposit';
    public $amount;
    public $date;
    public $proof_image;
    public $notes;
    
    public $startDate;
    public $endDate;

    protected $rules = [
        'type' => 'required|in:deposit,withdrawal',
        'amount' => 'required|numeric|min:0',
        'date' => 'required|date',
        'notes' => 'nullable|string',
    ];

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function render()
    {
        // Calculate Cash Balance (from transactions)
        $deposits = Transaction::where('type', 'deposit')
            ->where('status', 'approved')
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->sum('amount');
            
        $withdrawals = Transaction::where('type', 'withdrawal')
            ->where('status', 'approved')
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->sum('amount');
            
        $cashBalance = $deposits - $withdrawals;

        // Calculate Bank Balance (from bank deposits and withdrawals)
        $bankDepositsAmount = BankDeposit::where('type', 'deposit')
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->sum('amount');
            
        $bankWithdrawalsAmount = BankDeposit::where('type', 'withdrawal')
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->sum('amount');
            
        $bankBalance = $bankDepositsAmount - $bankWithdrawalsAmount;

        // Difference
        $difference = $cashBalance - $bankBalance;

        // Bank Deposits History (Paginator)
        $bankTransactions = BankDeposit::with('creator')
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->latest()
            ->paginate(10);

        return view('livewire.admin.reports', [
            'cashBalance' => $cashBalance,
            'bankBalance' => $bankBalance,
            'difference' => $difference,
            'deposits' => $deposits,
            'withdrawals' => $withdrawals,
            'bankTransactions' => $bankTransactions,
            'bankDepositsAmount' => $bankDepositsAmount,
            'bankWithdrawalsAmount' => $bankWithdrawalsAmount,
        ])->layout('components.layouts.admin', ['title' => 'Laporan']);
    }

    public function openDepositModal()
    {
        $this->resetForm();
        $this->type = 'deposit';
        $this->showDepositModal = true;
    }

    public function openWithdrawalModal()
    {
        $this->resetForm();
        $this->type = 'withdrawal';
        $this->showWithdrawalModal = true;
    }

    public function closeDepositModal()
    {
        $this->showDepositModal = false;
        $this->resetForm();
    }

    public function closeWithdrawalModal()
    {
        $this->showWithdrawalModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->type = 'deposit';
        $this->amount = '';
        $this->date = now()->format('Y-m-d');
        $this->notes = '';
        $this->resetErrorBag();
    }

    public function saveBankTransaction()
    {
        $this->validate();

        BankDeposit::create([
            'type' => $this->type,
            'amount' => $this->amount,
            'date' => $this->date,
            'notes' => $this->notes,
            'created_by' => Auth::id(),
        ]);

        $message = $this->type === 'deposit' 
            ? 'Setoran bank berhasil dicatat!' 
            : 'Penarikan bank berhasil dicatat!';
            
        session()->flash('message', $message);
        
        if ($this->type === 'deposit') {
            $this->closeDepositModal();
        } else {
            $this->closeWithdrawalModal();
        }
    }

    public function deleteBankDeposit($id)
    {
        BankDeposit::findOrFail($id)->delete();
        session()->flash('message', 'Catatan setoran bank berhasil dihapus!');
    }

    public function logout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }
}
