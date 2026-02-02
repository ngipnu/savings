<div x-data="{ 
    searchOpen: false,
    notificationOpen: false,
    init() {
        this.$watch('searchOpen', value => {
            if (value && this.$wire.search) {
                setTimeout(() => {
                    document.getElementById('search-results')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            }
        });
    }
}" 
x-init="
    Livewire.hook('morph.updated', ({ component }) => {
        if (component.fingerprint.name === 'admin.dashboard' && $wire.search && $wire.search.length > 0) {
            setTimeout(() => {
                document.getElementById('search-results')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 150);
        }
    });
">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a29] tracking-tight">Dashboard</h1>
            <p class="text-slate-500 mt-1">Selamat datang kembali, {{ $user->name }}</p>
        </div>
        <div class="flex items-center gap-3">
            <!-- Notification Bell -->
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
                            $pendingTransactions = \App\Models\Transaction::where('status', 'pending')
                                ->with(['user', 'savingType'])
                                ->latest()
                                ->take(5)
                                ->get();
                        @endphp
                        
                        @forelse($pendingTransactions as $transaction)
                            <a href="{{ route('admin.transactions') }}?filter=pending" class="block px-4 py-3 hover:bg-slate-50 transition-colors border-b border-slate-50">
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
                            <a href="{{ route('admin.transactions') }}?filter=pending" class="block text-center text-sm font-medium text-[#1e3a29] hover:text-lime-600">
                                Lihat Semua Transaksi Pending
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Search Toggle Button (Mobile Only) -->
            <button @click="searchOpen = !searchOpen" class="md:hidden p-2.5 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
            
            <!-- Desktop Search Box -->
            <div class="hidden md:block relative">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari transaksi..." class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm w-64 focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none pr-10">
                <svg class="w-4 h-4 text-slate-400 absolute right-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Mobile Search Box (Expandable) -->
    <div x-show="searchOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden mb-4 relative"
         x-cloak>
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari transaksi..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none pr-10" autofocus>
        <svg class="w-4 h-4 text-slate-400 absolute right-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
    </div>

    @if($search)
        <div class="mb-4 px-4 py-3 bg-lime-50 border border-lime-200 rounded-xl flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-lime-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <span class="text-sm font-medium text-lime-900">Hasil pencarian untuk: <strong>"{{ $search }}"</strong></span>
            </div>
            <button wire:click="$set('search', '')" class="text-lime-600 hover:text-lime-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Search Results Section -->
        <div id="search-results" class="mb-8 scroll-mt-4">
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-lime-50 to-white">
                    <h3 class="text-lg font-bold text-[#1e3a29]">Hasil Pencarian</h3>
                    <p class="text-sm text-slate-600 mt-1">Ditemukan {{ $recentTransactions->count() }} transaksi yang cocok</p>
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
                            <tr class="hover:bg-lime-50 transition-colors bg-lime-50/30">
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $transaction->created_at->format('d M Y') }}<br>
                                    <span class="text-xs text-slate-400">{{ $transaction->created_at->format('H:i') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800">{{ $transaction->user->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $transaction->user->student_id ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $transaction->savingType->name }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($transaction->type === 'deposit')
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-sm font-bold inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" /></svg>
                                            Setoran
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-sm font-bold inline-flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" /></svg>
                                            Penarikan
                                        </span>
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
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        <p class="font-medium">Tidak ada transaksi yang cocok dengan pencarian "{{ $search }}"</p>
                                        <button wire:click="$set('search', '')" class="mt-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-medium transition-colors">
                                            Hapus Filter
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Top Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <!-- Main Card (Dark Green) - Coinest Style -->
        <div class="lg:col-span-1 bg-[#1e3a29] rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl shadow-emerald-900/20 flex flex-col justify-between min-h-[220px]">
             <!-- Shapes -->
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
                <div class="text-emerald-100/70 text-sm font-medium mb-1">Total Assets</div>
                <div class="text-4xl font-bold tracking-tight">Rp {{ number_format($totalBalance, 0, ',', '.') }}</div>
            </div>

            <div class="flex justify-between items-end relative z-10 mt-auto pt-6">
                 <div>
                    <div class="text-xs text-emerald-100/50 uppercase tracking-widest mb-1">Holder</div>
                    <div class="font-medium tracking-wide">{{ $user->name }}</div>
                 </div>
                 <div class="text-right">
                    <div class="text-xs text-emerald-100/50 uppercase tracking-widest mb-1">Tahun Ajaran</div>
                    <div class="font-medium tracking-wide">{{ $activeYear ? $activeYear->name : '-' }}</div>
                 </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Income Card -->
            <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" /></svg>
                    </div>
                    <button class="text-slate-300 hover:text-slate-500">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>
                    </button>
                </div>
                <div>
                     <div class="text-sm text-slate-500 mb-1">Total Pemasukan</div>
                     <div class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
                </div>
                 <div class="mt-4 flex items-center gap-2">
                    @if($incomePercentage != 0)
                        <span class="px-2 py-1 {{ $incomePercentage >= 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }} text-xs font-bold rounded-lg">
                            {{ $incomePercentage >= 0 ? '+' : '' }}{{ number_format($incomePercentage, 1) }}%
                        </span>
                        <span class="text-xs text-slate-400">vs bulan lalu</span>
                    @else
                        <span class="text-xs text-slate-400">Belum ada data bulan lalu</span>
                    @endif
                 </div>
            </div>

            <!-- Expense Card -->
            <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                     <div class="w-10 h-10 rounded-full bg-rose-50 flex items-center justify-center text-rose-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" /></svg>
                    </div>
                     <button class="text-slate-300 hover:text-slate-500">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>
                    </button>
                </div>
                 <div>
                     <div class="text-sm text-slate-500 mb-1">Total Penarikan</div>
                     <div class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
                </div>
                 <div class="mt-4 flex items-center gap-2">
                    @if($expensePercentage != 0)
                        <span class="px-2 py-1 {{ $expensePercentage >= 0 ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }} text-xs font-bold rounded-lg">
                            {{ $expensePercentage >= 0 ? '+' : '' }}{{ number_format($expensePercentage, 1) }}%
                        </span>
                        <span class="text-xs text-slate-400">vs bulan lalu</span>
                    @else
                        <span class="text-xs text-slate-400">Belum ada data bulan lalu</span>
                    @endif
                 </div>
            </div>

             <!-- Savings/Plan Card (Coinest "Total Savings") -->
             <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-slate-100 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                     <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                     <button class="text-slate-300 hover:text-slate-500">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>
                    </button>
                </div>
                 <div>
                     <div class="text-sm text-slate-500 mb-1">Net Savings</div>
                     <div class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalSavings, 0, ',', '.') }}</div>
                </div>
                 <div class="mt-4 flex items-center gap-2">
                    @if($savingsPercentage != 0)
                        <span class="px-2 py-1 {{ $savingsPercentage >= 0 ? 'bg-lime-100 text-[#1e3a29]' : 'bg-rose-100 text-rose-700' }} text-xs font-bold rounded-lg">
                            {{ $savingsPercentage >= 0 ? '+' : '' }}{{ number_format($savingsPercentage, 1) }}%
                        </span>
                        <span class="text-xs text-slate-400">vs bulan lalu</span>
                    @else
                        <span class="text-xs text-slate-400">Belum ada data bulan lalu</span>
                    @endif
                 </div>
            </div>
        </div>
    </div>

    <!-- Middle Section: Chart and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Cashflow Chart (Placeholder Style) -->
        <div class="lg:col-span-2 bg-white rounded-[1.5rem] p-8 shadow-sm border border-slate-100">
             <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-bold text-[#1e3a29]">Cashflow</h3>
                    <div class="text-3xl font-bold mt-2 text-[#1e3a29]">Rp {{ number_format($totalBalance, 0, ',', '.') }}</div>
                </div>
                <div class="flex gap-2">
                    <span class="flex items-center gap-2 text-xs font-medium text-slate-500">
                        <span class="w-3 h-3 rounded-full bg-[#1e3a29]"></span> Income
                    </span>
                    <span class="flex items-center gap-2 text-xs font-medium text-slate-500">
                        <span class="w-3 h-3 rounded-full bg-[#bef264]"></span> Expense
                    </span>
                </div>
            </div>
            
            <!-- CSS Bar Chart with Real Data -->
            <div class="h-64 flex items-end justify-between gap-4 px-2">
                @foreach($monthlyData as $data)
                    @php
                        $incomeHeight = $maxValue > 0 ? ($data['income'] / $maxValue) * 100 : 0;
                        $expenseHeight = $maxValue > 0 ? ($data['expense'] / $maxValue) * 100 : 0;
                    @endphp
                    <div class="w-full bg-slate-50 rounded-t-xl relative group h-full flex items-end" title="{{ $data['month'] }}: Income Rp {{ number_format($data['income'], 0, ',', '.') }}, Expense Rp {{ number_format($data['expense'], 0, ',', '.') }}">
                        <div class="w-full bg-[#1e3a29] rounded-t-lg relative z-10 transition-all hover:bg-[#2a4d38]" style="height: {{ $incomeHeight }}%"></div>
                        <div class="absolute bottom-0 w-full bg-[#bef264] rounded-t-lg opacity-80" style="height: {{ $expenseHeight }}%"></div>
                    </div>
                @endforeach
            </div>
             <div class="flex justify-between mt-4 text-xs text-slate-400 font-medium px-2">
                @foreach($monthlyData as $data)
                    <span>{{ $data['month'] }}</span>
                @endforeach
            </div>
        </div>

        <!-- Quick Summary / Pending Transactions -->
        <div class="bg-white rounded-[1.5rem] p-8 shadow-sm border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-[#1e3a29]">Transaksi Pending</h3>
                <a href="{{ route('admin.transactions') }}" class="text-sm font-semibold text-[#1e3a29] hover:underline">Lihat Semua</a>
            </div>
            
            @php
                $pendingTransactions = \App\Models\Transaction::where('status', 'pending')->with(['user', 'savingType'])->latest()->take(5)->get();
                $pendingCount = \App\Models\Transaction::where('status', 'pending')->count();
            @endphp

            <div class="mb-6">
                <div class="text-sm text-slate-500 mb-1">Total Pending</div>
                <div class="text-3xl font-bold text-amber-600">{{ $pendingCount }} transaksi</div>
            </div>

            <!-- List -->
            <div class="space-y-4">
                @forelse($pendingTransactions as $transaction)
                <a href="{{ route('admin.transactions') }}?filter=pending" class="block bg-slate-50 rounded-xl p-4 border border-slate-100 hover:bg-slate-100 hover:border-slate-200 transition-all cursor-pointer group">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <div class="font-bold text-[#1e3a29] text-sm group-hover:text-lime-600 transition-colors">{{ $transaction->user->name }}</div>
                            <div class="text-xs text-slate-500">{{ $transaction->savingType->name }}</div>
                        </div>
                        <span class="px-2 py-1 {{ $transaction->type === 'deposit' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }} rounded-lg text-xs font-bold">
                            {{ $transaction->type === 'deposit' ? 'Setoran' : 'Penarikan' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-[#1e3a29]">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                        <span class="text-xs text-slate-400">{{ $transaction->created_at->diffForHumans() }}</span>
                    </div>
                </a>
                @empty
                <div class="text-center py-8 text-slate-400 text-sm">
                    Tidak ada transaksi pending
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Bottom Section: Transactions -->
    @if(!$search)
    <div class="bg-white rounded-[1.5rem] p-8 shadow-sm border border-slate-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-[#1e3a29]">Recent Transaction</h3>
            <div class="flex gap-2">
                <button class="px-3 py-1.5 border border-slate-200 rounded-lg text-xs font-medium text-slate-600 hover:bg-slate-50">This Month</button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs font-medium text-slate-400 uppercase tracking-wider border-b border-slate-100">
                        <th class="pb-4 pl-2">Transaction Name</th>
                        <th class="pb-4">Date & Time</th>
                        <th class="pb-4">Amount</th>
                        <th class="pb-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentTransactions as $transaction)
                    <tr class="group hover:bg-slate-50 transition-colors">
                        <td class="py-4 pl-2">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $transaction->type == 'deposit' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
                                     @if($transaction->type == 'deposit')
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-[#1e3a29] text-sm">{{ $transaction->savingType->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $transaction->user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 text-sm text-slate-500">
                            {{ $transaction->created_at->format('d M Y') }} <br>
                            <span class="text-xs text-slate-400">{{ $transaction->created_at->format('H:i') }}</span>
                        </td>
                        <td class="py-4 font-bold text-sm text-[#1e3a29]">
                            {{ $transaction->type === 'deposit' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </td>
                        <td class="py-4">
                            @if($transaction->status === 'approved')
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold">Success</span>
                            @elseif($transaction->status === 'pending')
                                <span class="px-2.5 py-1 rounded-lg bg-amber-100 text-amber-700 text-xs font-bold">Pending</span>
                            @else
                                <span class="px-2.5 py-1 rounded-lg bg-rose-100 text-rose-700 text-xs font-bold">Failed</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-slate-400 text-sm">No transactions found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
