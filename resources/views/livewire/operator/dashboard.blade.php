<div x-data="{ notificationOpen: false }">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a29] tracking-tight">Dashboard Operator</h1>
            <p class="text-slate-500 mt-1">Selamat datang, {{ $user->name }}</p>
        </div>
        <div class="relative" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open" class="p-2.5 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors relative">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                @if($notifications['unread_count'] > 0)
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ $notifications['unread_count'] }}</span>
                @endif
            </button>

            <!-- Notification Dropdown -->
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-96 bg-white rounded-xl shadow-xl border border-slate-200 z-50"
                 x-cloak>
                <div class="p-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800">Notifikasi</h3>
                    <p class="text-xs text-slate-500 mt-1">{{ $notifications['pending_count'] }} transaksi menunggu persetujuan</p>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    @php
                        $pendingNotifs = \App\Models\Transaction::where('status', 'pending')
                            ->with(['user', 'savingType'])
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp
                    
                    @forelse($pendingNotifs as $transaction)
                        <a href="{{ route('operator.transactions') ?? '#' }}" class="block px-4 py-3 hover:bg-slate-50 transition-colors border-b border-slate-50">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-full {{ $transaction->type === 'deposit' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }} flex items-center justify-center flex-shrink-0">
                                    @if($transaction->type === 'deposit')
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" /></svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" /></svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-slate-800 truncate">{{ $transaction->user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $transaction->savingType->name }} • Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                                    <p class="text-xs text-slate-400 mt-1">{{ $transaction->created_at->diffForHumans() }}</p>
                                </div>
                                <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded text-xs font-medium">Pending</span>
                            </div>
                        </a>
                    @empty
                        <div class="px-4 py-8 text-center text-slate-400 text-sm">
                            <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>Tidak ada notifikasi</p>
                        </div>
                    @endforelse
                </div>
                @if($notifications['pending_count'] > 0)
                    <div class="p-3 border-t border-slate-100">
                        <a href="{{ route('operator.transactions') ?? '#' }}" class="block text-center text-sm font-medium text-[#1e3a29] hover:text-lime-600">
                            Lihat Semua Transaksi Pending
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Today Transactions -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase font-medium">Transaksi Hari Ini</div>
                    <div class="text-2xl font-bold text-[#1e3a29]">{{ $todayTransactions }}</div>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase font-medium">Pending</div>
                    <div class="text-2xl font-bold text-amber-600">{{ $pendingTransactions }}</div>
                </div>
            </div>
        </div>

        <!-- Today Income -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" /></svg>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase font-medium">Setoran Hari Ini</div>
                    <div class="text-xl font-bold text-emerald-600">Rp {{ number_format($todayIncome, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <!-- Today Expense -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-xl bg-rose-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" /></svg>
                </div>
                <div>
                    <div class="text-xs text-slate-500 uppercase font-medium">Penarikan Hari Ini</div>
                    <div class="text-xl font-bold text-rose-600">Rp {{ number_format($todayExpense, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Action -->
    <div class="mb-8">
        <a href="{{ route('admin.transactions') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#1e3a29] text-white rounded-xl font-semibold hover:bg-[#2a4d38] transition-all shadow-lg shadow-emerald-900/20">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Input Transaksi Baru
        </a>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-[#1e3a29]">Transaksi Terbaru</h3>
            <a href="{{ route('admin.transactions') }}" class="text-sm font-semibold text-[#1e3a29] hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Siswa</th>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Jumlah</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentTransactions as $transaction)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $transaction->user->name }}</div>
                            <div class="text-xs text-slate-500">{{ $transaction->user->student_id }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            {{ $transaction->savingType->name }}
                        </td>
                        <td class="px-6 py-4">
                            @if($transaction->type === 'deposit')
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-sm font-bold">Setoran</span>
                            @else
                                <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-sm font-bold">Penarikan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-[#1e3a29]">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($transaction->status === 'approved')
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-bold">Disetujui</span>
                            @elseif($transaction->status === 'pending')
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-sm font-bold">Pending</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-sm font-bold">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            Belum ada transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
