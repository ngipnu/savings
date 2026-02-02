<?php

namespace App\Livewire\Student;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user()->load('classRoom.teacher');

        $savingTypes = \App\Models\SavingType::all();
        
        $accounts = [];
        $totalBalance = 0;

        foreach ($savingTypes as $type) {
            $typeDeposits = Transaction::where('user_id', $user->id)
                ->where('saving_type_id', $type->id)
                ->where('type', 'deposit')
                ->where('status', 'approved')
                ->sum('amount');

            $typeWithdrawals = Transaction::where('user_id', $user->id)
                ->where('saving_type_id', $type->id)
                ->where('type', 'withdrawal')
                ->where('status', 'approved')
                ->sum('amount');

            $typeBalance = $typeDeposits - $typeWithdrawals;
            
            // Only add if there's activity or balance
            if ($typeBalance > 0 || Transaction::where('user_id', $user->id)->where('saving_type_id', $type->id)->exists()) {
                $accounts[] = [
                    'id' => $type->id,
                    'name' => $type->name,
                    'balance' => $typeBalance,
                ];
            }
            
            $totalBalance += $typeBalance;
        }

        // Always ensure at least one "General" or empty card if no accounts exist
        if (empty($accounts)) {
             $accounts[] = [
                'id' => 0,
                'name' => 'Total Tabungan',
                'balance' => 0,
            ];
        }

        $recentTransactions = Transaction::with('savingType')
            ->where('user_id', $user->id)
            ->latest('date')
            ->take(10)
            ->get();

        // Get Notifications
        $notifications = $this->getNotifications($user->id);

        return view('livewire.student.dashboard', [
            'accounts' => $accounts,
            'totalBalance' => $totalBalance,
            'recentTransactions' => $recentTransactions,
            'user' => $user,
            'notifications' => $notifications,
        ])->layout('components.layouts.app', ['title' => 'Dashboard Siswa']);
    }

    private function getNotifications($userId)
    {
        $pendingCount = Transaction::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();
        
        $recentCount = Transaction::where('user_id', $userId)
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->count();
        
        return [
            'pending_count' => $pendingCount,
            'recent_count' => $recentCount,
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
