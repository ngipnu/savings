<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class TransactionReceipt extends Component
{
    public $transaction;

    public function mount($id)
    {
        $this->transaction = \App\Models\Transaction::with(['user', 'savingType'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.transaction-receipt')
            ->layout('components.layouts.app', ['title' => 'Bukti Transaksi']); 
            // Using 'app' layout or a blank layout for printing? 
            // Better to have a simple layout. I'll use 'app' but the view will handle print styles.
    }
}
