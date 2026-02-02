<div>
    @if(!$hasClass)
        <!-- No Class Assigned -->
        <div class="flex items-center justify-center min-h-[60vh]">
            <div class="text-center">
                <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Kelas</h3>
                <p class="text-slate-500">Anda belum ditugaskan sebagai wali kelas. Hubungi admin untuk penugasan kelas.</p>
            </div>
        </div>
    @else
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-[#1e3a29] tracking-tight">Dashboard Wali Kelas</h1>
                <p class="text-slate-500 mt-1">Kelas {{ $teacherClass->name }} - {{ $user->name }}</p>
            </div>
            <div class="flex items-center gap-2">
                <!-- Notification Bell -->
                <div class="relative">
                    <button class="p-2.5 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors relative">
                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if($notifications['unread_count'] > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ $notifications['unread_count'] }}</span>
                        @endif
                    </button>
                </div>
                
                <!-- Profile Button -->
                <a href="{{ route('wali-kelas.profile') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-colors font-medium flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span class="hidden md:inline">Profile Saya</span>
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Students -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 uppercase font-medium">Total Siswa</div>
                        <div class="text-2xl font-bold text-[#1e3a29]">{{ $totalStudents }}</div>
                    </div>
                </div>
            </div>

            <!-- Class Balance -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 uppercase font-medium">Saldo Kelas</div>
                        <div class="text-xl font-bold text-emerald-600">Rp {{ number_format($classBalance, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <!-- Total Deposits -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-lime-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-lime-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" /></svg>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 uppercase font-medium">Total Setoran</div>
                        <div class="text-xl font-bold text-lime-600">Rp {{ number_format($totalDeposits, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <!-- Total Withdrawals -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-rose-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" /></svg>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 uppercase font-medium">Total Penarikan</div>
                        <div class="text-xl font-bold text-rose-600">Rp {{ number_format($totalWithdrawals, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Top Savers -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-lg font-bold text-[#1e3a29] mb-6">Top 5 Penabung Terbaik</h3>
                <div class="space-y-4">
                    @forelse($topSavers as $index => $saver)
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full {{ $index === 0 ? 'bg-yellow-100 text-yellow-600' : ($index === 1 ? 'bg-slate-200 text-slate-600' : ($index === 2 ? 'bg-orange-100 text-orange-600' : 'bg-slate-100 text-slate-500')) }} flex items-center justify-center font-bold">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-slate-800">{{ $saver->name }}</div>
                                <div class="text-xs text-slate-500">{{ $saver->student_id }}</div>
                            </div>
                            <div class="text-right">
                                <div class="font-bold text-[#1e3a29]">Rp {{ number_format($saver->total_savings ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-slate-400 py-8">Belum ada data tabungan</div>
                    @endforelse
                </div>
            </div>

            <!-- All Students List -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-[#1e3a29]">Daftar Siswa</h3>
                    <a href="{{ route('admin.students') }}" class="text-sm font-semibold text-[#1e3a29] hover:underline">Kelola Siswa</a>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 sticky top-0">
                            <tr class="text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <th class="px-6 py-3">NIS</th>
                                <th class="px-6 py-3">Nama</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($students as $student)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-3 text-sm font-mono font-bold text-[#1e3a29]">{{ $student->student_id }}</td>
                                <td class="px-6 py-3 text-sm text-slate-800">{{ $student->name }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-6 py-8 text-center text-slate-400">
                                    Belum ada siswa di kelas ini
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
