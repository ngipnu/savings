<?php

namespace App\Livewire\Student;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();

        $deposits = Transaction::where('user_id', $user->id)
            ->where('type', 'deposit')
            ->where('status', 'approved')
            ->sum('amount');

        $withdrawals = Transaction::where('user_id', $user->id)
            ->where('type', 'withdrawal')
            ->where('status', 'approved')
            ->sum('amount');

        $balance = $deposits - $withdrawals;

        $recentTransactions = Transaction::with('savingType')
            ->where('user_id', $user->id)
            ->latest('date')
            ->take(10)
            ->get();

        return view('livewire.student.dashboard', [
            'balance' => $balance,
            'recentTransactions' => $recentTransactions,
            'user' => $user
        ])->layout('components.layouts.app', ['title' => 'Dashboard Siswa']);
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }
}
