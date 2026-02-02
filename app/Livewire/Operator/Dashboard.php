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
            ->whereIn('status', ['approved', 'pending'])
            ->whereDate('date', today())
            ->sum('amount');
        $todayExpense = Transaction::where('type', 'withdrawal')
            ->whereIn('status', ['approved', 'pending'])
            ->whereDate('date', today())
            ->sum('amount');

        // Recent transactions
        $recentTransactions = Transaction::with(['user', 'savingType'])
            ->latest()
            ->take(10)
            ->get();

        // Get Notifications
        $notifications = $this->getNotifications();

        return view('livewire.operator.dashboard', [
            'todayTransactions' => $todayTransactions,
            'pendingTransactions' => $pendingTransactions,
            'todayIncome' => $todayIncome,
            'todayExpense' => $todayExpense,
            'recentTransactions' => $recentTransactions,
            'user' => Auth::user(),
            'notifications' => $notifications,
        ])->layout('components.layouts.admin', ['title' => 'Dashboard Operator']);
    }

    private function getNotifications()
    {
        $pendingCount = Transaction::where('status', 'pending')->count();
        $todayTransactions = Transaction::whereDate('created_at', today())->count();
        
        return [
            'pending_count' => $pendingCount,
            'today_transactions' => $todayTransactions,
            'unread_count' => $pendingCount,
        ];
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }
}
