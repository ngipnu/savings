<div>
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a29] tracking-tight">Dashboard</h1>
            <p class="text-slate-500 mt-1">Selamat datang kembali, {{ $user->name }}</p>
        </div>
        <div>
             <div class="relative">
                <input type="text" placeholder="Search..." class="bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-sm w-64 focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                <svg class="w-4 h-4 text-slate-400 absolute right-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

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
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <div class="font-bold text-[#1e3a29] text-sm">{{ $transaction->user->name }}</div>
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
                </div>
                @empty
                <div class="text-center py-8 text-slate-400 text-sm">
                    Tidak ada transaksi pending
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Bottom Section: Transactions -->
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
</div>
