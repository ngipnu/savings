<?php

namespace App\Livewire\Admin;

use App\Models\Transaction;
use App\Models\User;
use App\Models\SavingType; // Need for total savings
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        // Current month dates
        $currentMonthStart = now()->startOfMonth()->format('Y-m-d');
        $currentMonthEnd = now()->endOfMonth()->format('Y-m-d');
        
        // Previous month dates
        $previousMonthStart = now()->subMonth()->startOfMonth()->format('Y-m-d');
        $previousMonthEnd = now()->subMonth()->endOfMonth()->format('Y-m-d');

        // 1. Calculate Total Balance (All Time)
        $deposits = Transaction::where('type', 'deposit')->where('status', 'approved')->sum('amount');
        $withdrawals = Transaction::where('type', 'withdrawal')->where('status', 'approved')->sum('amount');
        $totalBalance = $deposits - $withdrawals;

        // 2. Calculate Current Month Stats
        $currentMonthIncome = Transaction::where('type', 'deposit')
            ->where('status', 'approved')
            ->whereBetween('date', [$currentMonthStart, $currentMonthEnd])
            ->sum('amount');
            
        $currentMonthExpense = Transaction::where('type', 'withdrawal')
            ->where('status', 'approved')
            ->whereBetween('date', [$currentMonthStart, $currentMonthEnd])
            ->sum('amount');

        // 3. Calculate Previous Month Stats for comparison
        $previousMonthIncome = Transaction::where('type', 'deposit')
            ->where('status', 'approved')
            ->whereBetween('date', [$previousMonthStart, $previousMonthEnd])
            ->sum('amount');
            
        $previousMonthExpense = Transaction::where('type', 'withdrawal')
            ->where('status', 'approved')
            ->whereBetween('date', [$previousMonthStart, $previousMonthEnd])
            ->sum('amount');

        // 4. Calculate Percentage Changes
        $incomePercentage = $previousMonthIncome > 0 
            ? round((($currentMonthIncome - $previousMonthIncome) / $previousMonthIncome) * 100, 1)
            : 0;
            
        $expensePercentage = $previousMonthExpense > 0 
            ? round((($currentMonthExpense - $previousMonthExpense) / $previousMonthExpense) * 100, 1)
            : 0;
            
        $savingsPercentage = ($previousMonthIncome - $previousMonthExpense) > 0
            ? round(((($currentMonthIncome - $currentMonthExpense) - ($previousMonthIncome - $previousMonthExpense)) / ($previousMonthIncome - $previousMonthExpense)) * 100, 1)
            : 0;

        // 5. Calculate Monthly Cashflow for Chart (Last 12 months)
        $monthlyData = [];
        for ($i = 11; $i >= 0; $i--) {
            $monthStart = now()->subMonths($i)->startOfMonth()->format('Y-m-d');
            $monthEnd = now()->subMonths($i)->endOfMonth()->format('Y-m-d');
            
            $monthIncome = Transaction::where('type', 'deposit')
                ->where('status', 'approved')
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->sum('amount');
                
            $monthExpense = Transaction::where('type', 'withdrawal')
                ->where('status', 'approved')
                ->whereBetween('date', [$monthStart, $monthEnd])
                ->sum('amount');
            
            $monthlyData[] = [
                'month' => now()->subMonths($i)->format('M'),
                'income' => $monthIncome,
                'expense' => $monthExpense,
            ];
        }
        
        // Find max value for chart scaling
        $maxValue = 1;
        foreach ($monthlyData as $data) {
            $maxValue = max($maxValue, $data['income'], $data['expense']);
        }

        // 3. Transactions List
        $recentTransactions = Transaction::with(['user', 'savingType'])
            ->latest()
            ->take(5)
            ->get();

        // 4. Get Active Academic Year
        $activeYear = \App\Models\AcademicYear::where('is_active', true)->first();

        return view('livewire.admin.dashboard', [
            'totalBalance' => $totalBalance,
            'totalIncome' => $deposits,
            'totalExpense' => $withdrawals,
            'totalSavings' => $totalBalance,
            'currentMonthIncome' => $currentMonthIncome,
            'currentMonthExpense' => $currentMonthExpense,
            'incomePercentage' => $incomePercentage,
            'expensePercentage' => $expensePercentage,
            'savingsPercentage' => $savingsPercentage,
            'monthlyData' => $monthlyData,
            'maxValue' => $maxValue,
            'recentTransactions' => $recentTransactions,
            'activeYear' => $activeYear,
            'user' => Auth::user(),
        ])->layout('components.layouts.admin', ['title' => 'Admin Dashboard']);
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }
}
