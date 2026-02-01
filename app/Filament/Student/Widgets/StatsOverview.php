<?php

namespace App\Filament\Student\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();

        $deposits = Transaction::where('user_id', $user->id)
            ->where('type', 'deposit')
            ->where('status', 'approved')
            ->sum('amount');

        $withdrawals = Transaction::where('user_id', $user->id)
            ->where('type', 'withdrawal')
            ->where('status', 'approved')
            ->sum('amount');

        $balance = $deposits - $withdrawals;

        return [
            Stat::make('Total Balance', 'IDR ' . number_format($balance, 0, ',', '.'))
                ->description('Current savings balance')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
            
            Stat::make('Pending Deposits', Transaction::where('user_id', $user->id)->where('type', 'deposit')->where('status', 'pending')->count())
                ->label('Pending Deposits')
                ->description('Waiting for approval')
                ->color('warning'),
        ];
    }
}
