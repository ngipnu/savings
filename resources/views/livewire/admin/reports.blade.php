<div>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#1e3a29] tracking-tight">Laporan Keuangan</h1>
        <p class="text-slate-500 mt-1">Sinkronisasi dana cash dan bank</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl">
            {{ session('message') }}
        </div>
    @endif

    <!-- Date Filter -->
    <div class="mb-6 bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Dari Tanggal</label>
                <input wire:model.live="startDate" type="date" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Sampai Tanggal</label>
                <input wire:model.live="endDate" type="date" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
            </div>
            <div>
                <button wire:click="openDepositModal" class="px-4 py-2.5 md:px-6 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition-all mr-3">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M12 9.75l-3 3m0 0l3 3m-3-3h7.5M12 9.75V3" />
                         </svg>
                        <span class="hidden md:inline">Catat Setoran Bank</span>
                    </span>
                </button>
                <button wire:click="openWithdrawalModal" class="px-4 py-2.5 md:px-6 bg-rose-600 text-white rounded-lg font-semibold hover:bg-rose-700 transition-all">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span class="hidden md:inline">Catat Penarikan Bank</span>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Cash Balance -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase font-medium">Saldo Cash</div>
                    <div class="text-2xl font-bold text-[#1e3a29]">Rp {{ number_format($cashBalance, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="text-xs text-slate-500">Dari transaksi aplikasi</div>
        </div>

        <!-- Bank Balance -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase font-medium">Saldo Bank</div>
                    <div class="text-2xl font-bold text-[#1e3a29]">Rp {{ number_format($bankBalance, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="space-y-1">
                <div class="flex justify-between text-xs">
                    <span class="text-slate-500">Setoran:</span>
                    <span class="font-bold text-emerald-600">+Rp {{ number_format($bankDepositsAmount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-slate-500">Penarikan:</span>
                    <span class="font-bold text-rose-600">-Rp {{ number_format($bankWithdrawalsAmount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Difference -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-xl {{ $difference >= 0 ? 'bg-lime-100' : 'bg-red-100' }} flex items-center justify-center">
                    <svg class="w-6 h-6 {{ $difference >= 0 ? 'text-lime-600' : 'text-red-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase font-medium">Selisih</div>
                    <div class="text-2xl font-bold {{ $difference >= 0 ? 'text-lime-600' : 'text-red-600' }}">
                        Rp {{ number_format(abs($difference), 0, ',', '.') }}
                    </div>
                </div>
            </div>
            <div class="text-xs text-slate-500">{{ $difference >= 0 ? 'Belum disetor' : 'Kelebihan setor' }}</div>
        </div>

        <!-- Total Transactions -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
            <div class="text-xs text-slate-500 uppercase font-medium mb-3">Ringkasan Transaksi</div>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-600">Pemasukan:</span>
                    <span class="font-bold text-emerald-600">+Rp {{ number_format($deposits, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-600">Penarikan:</span>
                    <span class="font-bold text-rose-600">-Rp {{ number_format($withdrawals, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bank Deposits & Withdrawals History -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="text-lg font-bold text-[#1e3a29]">Riwayat Transaksi Bank</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                        <th class="px-3 py-3 md:px-6 md:py-4">Tanggal</th>
                        <th class="px-3 py-3 md:px-6 md:py-4">Tipe</th>
                        <th class="px-3 py-3 md:px-6 md:py-4">Jumlah</th>
                        <th class="px-3 py-3 md:px-6 md:py-4 hidden md:table-cell">Keterangan</th>
                        <th class="px-3 py-3 md:px-6 md:py-4 hidden md:table-cell">Dicatat Oleh</th>
                        <th class="px-3 py-3 md:px-6 md:py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bankTransactions as $deposit)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-3 py-3 md:px-6 md:py-4 text-xs md:text-sm text-slate-600">
                            {{ \Carbon\Carbon::parse($deposit->date)->format('d M Y') }}
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4">
                            @if($deposit->type === 'deposit')
                                <span class="px-2 py-1 md:px-3 md:py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs md:text-sm font-bold">Setoran</span>
                            @else
                                <span class="px-2 py-1 md:px-3 md:py-1 bg-rose-100 text-rose-700 rounded-lg text-xs md:text-sm font-bold">Penarikan</span>
                            @endif
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4">
                            <span class="font-bold {{ $deposit->type === 'deposit' ? 'text-emerald-600' : 'text-rose-600' }} text-sm md:text-base">
                                {{ $deposit->type === 'deposit' ? '+' : '-' }}Rp {{ number_format($deposit->amount, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4 text-xs md:text-sm text-slate-600 hidden md:table-cell">
                            {{ $deposit->notes ?? '-' }}
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4 text-xs md:text-sm text-slate-600 hidden md:table-cell">
                            {{ $deposit->creator->name }}
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4">
                            <button wire:click="deleteBankDeposit({{ $deposit->id }})" wire:confirm="Yakin ingin menghapus catatan ini?" class="px-2 py-1 md:px-3 md:py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-xs md:text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:hidden">
                                     <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                                <span class="hidden md:inline">Hapus</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            Belum ada transaksi bank
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $bankTransactions->links() }}
        </div>
    </div>

    <!-- Deposit Modal -->
    @if($showDepositModal)
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8">
            <h2 class="text-2xl font-bold text-[#1e3a29] mb-6">Catat Setoran Bank</h2>

            <form wire:submit="saveBankTransaction" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah (Rp)</label>
                    <input wire:model="amount" type="number" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="1000000">
                    @error('amount') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Setor</label>
                    <input wire:model="date" type="date" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                    @error('date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Keterangan</label>
                    <textarea wire:model="notes" rows="3" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="Setoran rutin bulan ini"></textarea>
                    @error('notes') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" wire:click="closeDepositModal" class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition-colors font-medium">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors font-medium">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Withdrawal Modal -->
    @if($showWithdrawalModal)
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8">
            <h2 class="text-2xl font-bold text-[#1e3a29] mb-6">Catat Penarikan Bank</h2>

            <form wire:submit="saveBankTransaction" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah (Rp)</label>
                    <input wire:model="amount" type="number" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="1000000">
                    @error('amount') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Tarik</label>
                    <input wire:model="date" type="date" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                    @error('date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Keterangan</label>
                    <textarea wire:model="notes" rows="3" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="Penarikan untuk pencairan tabungan siswa"></textarea>
                    @error('notes') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" wire:click="closeWithdrawalModal" class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition-colors font-medium">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition-colors font-medium">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
