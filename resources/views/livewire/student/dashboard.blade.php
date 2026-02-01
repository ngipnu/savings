<div class="min-h-screen bg-slate-50 pb-20">
    <!-- Mobile Header -->
    <div class="bg-white px-6 py-6 shadow-sm sticky top-0 z-20 flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold text-[#1e3a29]">Halo, {{ explode(' ', $user->name)[0] }}! 👋</h1>
            <p class="text-xs text-slate-500">Siswa Kelas {{ $user->class_name }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="/student/profile" class="p-2 rounded-xl bg-lime-50 text-[#1e3a29] hover:bg-lime-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </a>
            <button wire:click="logout" class="p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-red-50 hover:text-red-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
            </button>
        </div>
    </div>

    <div class="p-6 space-y-8 max-w-lg mx-auto">
        <!-- Balance Card - Admin Style -->
        <div class="bg-[#1e3a29] rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl shadow-emerald-900/20 flex flex-col justify-between min-h-[220px]">
            <!-- Decorative Shapes -->
            <div class="absolute top-0 right-0 w-48 h-48 bg-[#bef264] rounded-full blur-[80px] opacity-20 -translate-y-1/2 translate-x-1/2"></div>
            
            <div class="flex justify-between items-start relative z-10 w-full">
                <div class="flex gap-1.5">
                    <div class="w-6 h-6 rounded-full bg-[#bef264]/80"></div>
                    <div class="w-6 h-6 rounded-full bg-white/20 -ml-3"></div>
                </div>
                <div class="flex gap-2">
                    <div class="w-10 h-6 bg-red-400/80 rounded-lg"></div>
                    <div class="w-10 h-6 bg-yellow-400/80 rounded-lg -ml-6 opacity-80 mix-blend-multiply"></div>
                </div>
            </div>

            <div class="relative z-10 mt-6">
                <div class="text-emerald-100/70 text-sm font-medium mb-1">Total Tabungan Anda</div>
                <div class="text-4xl font-bold tracking-tight">
                    Rp {{ number_format($balance, 0, ',', '.') }}
                </div>
            </div>

            <div class="flex justify-between items-end relative z-10 mt-auto pt-6">
                <div>
                    <div class="text-xs text-emerald-100/50 uppercase tracking-widest mb-1">Holder</div>
                    <div class="font-medium tracking-wide">{{ explode(' ', $user->name)[0] }}</div>
                </div>
                <div class="text-right">
                    <div class="text-xs text-emerald-100/50 uppercase tracking-widest mb-1">Aktif Sejak</div>
                    <div class="font-medium tracking-wide">{{ $user->created_at->format('M Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div>
            <div class="flex justify-between items-end mb-4">
                <h2 class="text-lg font-bold text-slate-800">Riwayat Terakhir</h2>
                <button class="text-xs font-semibold text-[#1e3a29] hover:text-[#2a4d38]">Lihat Semua</button>
            </div>
            
            <div class="space-y-4">
                @forelse($recentTransactions as $transaction)
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between hover:shadow-md transition duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center 
                                {{ $transaction->type === 'deposit' ? 'bg-lime-50 text-[#1e3a29]' : 'bg-rose-50 text-rose-600' }}">
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
                            <div class="font-bold text-sm {{ $transaction->type === 'deposit' ? 'text-[#1e3a29]' : 'text-slate-800' }}">
                                {{ $transaction->type === 'deposit' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </div>
                            @if($transaction->status === 'approved')
                                <div class="text-[10px] uppercase font-bold tracking-wider mt-1 text-lime-600">
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
