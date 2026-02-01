<?php

namespace App\Livewire\Operator;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // Stats for Operator
        $todayTransactions = Transaction::whereDate('date', today())->count();
        $pendingTransactions = Transaction::where('status', 'pending')->count();
        $todayIncome = Transaction::where('type', 'deposit')
            ->where('status', 'approved')
            ->whereDate('date', today())
            ->sum('amount');
        $todayExpense = Transaction::where('type', 'withdrawal')
            ->where('status', 'approved')
            ->whereDate('date', today())
            ->sum('amount');

        // Recent transactions
        $recentTransactions = Transaction::with(['user', 'savingType'])
            ->latest()
            ->take(10)
            ->get();

        return view('livewire.operator.dashboard', [
            'todayTransactions' => $todayTransactions,
            'pendingTransactions' => $pendingTransactions,
            'todayIncome' => $todayIncome,
            'todayExpense' => $todayExpense,
            'recentTransactions' => $recentTransactions,
            'user' => Auth::user(),
        ])->layout('components.layouts.admin', ['title' => 'Dashboard Operator']);
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }
}
