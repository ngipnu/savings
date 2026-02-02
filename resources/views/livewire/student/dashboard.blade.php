<div class="min-h-screen bg-transparent pb-20">
    <!-- Mobile Header -->
    <div class="bg-white px-6 py-6 shadow-sm sticky top-0 z-20 flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold text-[#1e3a29]">Halo, {{ explode(' ', $user->name)[0] }}! 👋</h1>
            <div class="text-xs text-slate-500">
                <p>Siswa Kelas {{ $user->classRoom ? $user->classRoom->name : $user->class_name }}</p>
                @if($user->classRoom && $user->classRoom->teacher)
                    <p class="flex items-center gap-1 mt-0.5 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3 h-3">
                            <path d="M7 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM14.5 9a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM1.615 16.428a1.224 1.224 0 0 1-.569-1.175 6.002 6.002 0 0 1 11.532-2.407 2.885 2.885 0 0 0-.628 1.502c.043.503.24 2.973 2.13 3.986a6.002 6.002 0 0 1-7.729-1.906Zm12.76 3.643a1.224 1.224 0 0 0 .569-1.175 6.002 6.002 0 0 0-11.532-2.407 2.885 2.885 0 0 1 .628 1.502c-.043.503-.24 2.973-2.13 3.986a6.002 6.002 0 0 0 7.729-1.906Z" />
                        </svg>
                        Wali Kelas: {{ $user->classRoom->teacher->name }}
                    </p>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-2">
            <!-- Notification Bell -->
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="p-2 rounded-xl bg-slate-50 text-slate-600 hover:bg-slate-100 transition relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                     class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-slate-200 z-50"
                     x-cloak>
                    <div class="p-4 border-b border-slate-100">
                        <h3 class="font-bold text-slate-800">Notifikasi Saya</h3>
                        <p class="text-xs text-slate-500 mt-1">{{ $notifications['pending_count'] }} transaksi pending</p>
                    </div>
                    <div class="max-h-80 overflow-y-auto">
                        @php
                            $myPendingTransactions = \App\Models\Transaction::where('user_id', $user->id)
                                ->where('status', 'pending')
                                ->with('savingType')
                                ->latest()
                                ->take(5)
                                ->get();
                        @endphp
                        
                        @forelse($myPendingTransactions as $transaction)
                            <div class="px-4 py-3 border-b border-slate-50">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-full {{ $transaction->type === 'deposit' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }} flex items-center justify-center flex-shrink-0">
                                        @if($transaction->type === 'deposit')
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" /></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" /></svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-slate-800">{{ $transaction->savingType->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $transaction->type === 'deposit' ? 'Setoran' : 'Penarikan' }} • Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                                        <p class="text-xs text-slate-400 mt-1">{{ $transaction->created_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded text-xs font-medium">Pending</span>
                                </div>
                            </div>
                        @empty
                            <div class="px-4 py-8 text-center text-slate-400 text-sm">
                                <svg class="w-12 h-12 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p>Semua transaksi sudah diproses</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <!-- Profile Icon -->
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
        <!-- Balance Cards Slider -->
        <div class="flex overflow-x-auto snap-x snap-mandatory gap-4 pb-4 -mx-6 px-6 scrollbar-hide">
            @foreach($accounts as $account)
            <div class="w-full flex-shrink-0 snap-center bg-[#1e3a29] rounded-[2rem] p-8 text-white relative overflow-hidden shadow-xl shadow-emerald-900/20 flex flex-col justify-between min-h-[220px]">
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
                    <div class="text-emerald-100/70 text-sm font-medium mb-1">{{ $account['name'] }}</div>
                    <div class="text-4xl font-bold tracking-tight">
                        Rp {{ number_format($account['balance'], 0, ',', '.') }}
                    </div>
                </div>

                <div class="flex justify-between items-end relative z-10 mt-auto pt-6">
                    <div>
                        <div class="text-xs text-emerald-100/50 uppercase tracking-widest mb-1">Holder</div>
                        <div class="font-medium tracking-wide">{{ $user->name }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-emerald-100/50 uppercase tracking-widest mb-1">Aktif Sejak</div>
                        <div class="font-medium tracking-wide">{{ $user->created_at->format('M Y') }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination Dots -->
        @if(count($accounts) > 1)
        <div class="flex justify-center gap-2 -mt-4">
            @foreach($accounts as $index => $account)
            <div class="w-2 h-2 rounded-full {{ $index === 0 ? 'bg-[#1e3a29]' : 'bg-slate-300' }}"></div>
            @endforeach
        </div>
        @endif

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
