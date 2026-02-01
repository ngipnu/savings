<div class="min-h-screen bg-slate-50 pb-20">
    <!-- Mobile Header -->
    <div class="bg-white px-6 py-6 shadow-sm sticky top-0 z-20 flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Halo, {{ explode(' ', $user->name)[0] }}! 👋</h1>
            <p class="text-xs text-slate-500">Siswa Kelas {{ $user->class_name }}</p>
        </div>
        <div class="relative group">
             <button wire:click="logout" class="p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-red-50 hover:text-red-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
            </button>
        </div>
    </div>

    <div class="p-6 space-y-8 max-w-lg mx-auto">
        <!-- Balance Card -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-600 p-8 text-white shadow-emerald-200 shadow-xl">
            <!-- Decorative Circles -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-emerald-300 opacity-20 rounded-full blur-xl"></div>
            
            <div class="relative z-10">
                <div class="text-emerald-100 text-sm font-medium mb-2">Total Tabungan Anda</div>
                <div class="text-4xl font-bold tracking-tight mb-6">
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </div>
                
                <div class="flex items-center gap-3 bg-white/20 backdrop-blur-md rounded-xl p-3 w-fit border border-white/10">
                    <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold">Aktif Sejak {{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div>
            <div class="flex justify-between items-end mb-4">
                <h2 class="text-lg font-bold text-slate-800">Riwayat Terakhir</h2>
                <button class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Lihat Semua</button>
            </div>
            
            <div class="space-y-4">
                @forelse($recentTransactions as $transaction)
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center 
                                {{ $transaction->type === 'deposit' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                @if($transaction->type === 'deposit')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <div class="font-bold text-slate-800 text-sm">{{ $transaction->savingType->name }}</div>
                                <div class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-sm {{ $transaction->type === 'deposit' ? 'text-emerald-600' : 'text-slate-800' }}">
                                {{ $transaction->type === 'deposit' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </div>
                            @if($transaction->status === 'approved')
                                <div class="text-[10px] uppercase font-bold tracking-wider mt-1 text-emerald-500">
                                    {{ $transaction->status }}
                                </div>
                            @elseif($transaction->status === 'pending')
                                <div class="text-[10px] uppercase font-bold tracking-wider mt-1 text-amber-500">
                                    {{ $transaction->status }}
                                </div>
                            @else
                                <div class="text-[10px] uppercase font-bold tracking-wider mt-1 text-red-500">
                                    {{ $transaction->status }}
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-white rounded-2xl border border-dashed border-slate-200">
                        <div class="text-slate-400 text-sm">Belum ada transaksi</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
