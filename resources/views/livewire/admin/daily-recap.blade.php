<div class="space-y-6">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a29] tracking-tight">Neraca Mutasi Harian</h1>
            <p class="text-slate-500 mt-1">Laporan mutasi tabungan siswa (Setoran - Penarikan)</p>
        </div>
        <div class="flex gap-3">
            <button onclick="window.print()" class="px-6 py-3 bg-[#1e3a29] text-white rounded-xl font-semibold hover:bg-[#2a4d38] transition-all shadow-lg shadow-emerald-900/20 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 012-2H9a2 2 0 01-2 2v4h10z" /></svg>
                <span class="hidden md:inline">Cetak Laporan</span>
            </button>
            <a href="{{ route('admin.transactions') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-semibold hover:bg-slate-200 transition-all shadow-sm flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
        <div class="flex flex-wrap items-center gap-6">
            <div class="flex items-center gap-3">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Dari Tanggal:</label>
                <input wire:model.live="startDate" type="date" class="px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 outline-none text-sm shadow-sm bg-white">
            </div>
            <div class="flex items-center gap-3">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sampai Tanggal:</label>
                <input wire:model.live="endDate" type="date" class="px-4 py-2 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 outline-none text-sm shadow-sm bg-white">
            </div>
            <div class="text-xs text-slate-400 italic">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Menampilkan selisih mutasi (Setoran - Penarikan). Angka dalam kurung ( ) adalah penarikan.
                </span>
            </div>
        </div>
    </div>

    <!-- Matrix Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto max-h-[70vh]">
            <table class="w-full border-collapse border border-slate-200 table-fixed min-w-[1000px]">
                <thead class="sticky top-0 z-20 bg-white">
                    <tr class="bg-slate-100 text-slate-600 text-[10px] uppercase font-bold tracking-wider">
                        <th class="px-6 py-4 text-left border border-slate-200 w-64 shadow-sm" rowspan="2">Nama Siswa / Tanggal</th>
                        <th class="px-4 py-3 text-center border border-slate-200" colspan="{{ count($recap['dates']) }}">Mutasi Harian (Rp)</th>
                    </tr>
                    <tr class="bg-slate-50 text-slate-500 text-[10px] uppercase font-bold tracking-wider text-center">
                        @foreach($recap['dates'] as $date)
                            <th class="px-2 py-3 border border-slate-200">{{ \Carbon\Carbon::parse($date)->format('d/m/y') }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recap['classes'] as $classGroup)
                        <tr class="bg-slate-100 pointer-events-none sticky z-10">
                            <td colspan="{{ count($recap['dates']) + 1 }}" class="px-6 py-2.5 font-black text-[#1e3a29] border border-slate-200 uppercase text-[11px] tracking-widest bg-emerald-50">
                                {{ $classGroup['name'] }}
                            </td>
                        </tr>
                        @foreach($classGroup['students'] as $student)
                            <tr class="hover:bg-slate-50 transition-all border border-slate-200">
                                <td class="px-6 py-3 text-slate-700 sticky left-0 bg-white border border-slate-200 shadow-[2px_0_5px_rgba(0,0,0,0.02)]">
                                    <div class="font-bold text-sm truncate">{{ $student['name'] }}</div>
                                    <div class="text-[10px] text-slate-400 tracking-wider uppercase">{{ $student['student_id'] }}</div>
                                </td>
                                @foreach($recap['dates'] as $date)
                                    @php $val = $student['history'][$date] ?? 0; @endphp
                                    <td class="px-2 py-3 text-center border border-slate-200 text-sm {{ $val > 0 ? 'text-emerald-600 font-bold' : ($val < 0 ? 'text-rose-600 font-bold' : 'text-slate-300') }}">
                                        @if($val != 0)
                                            {{ $val > 0 ? number_format($val, 0, ',', '.') : '(' . number_format(abs($val), 0, ',', '.') . ')' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="{{ count($recap['dates']) + 1 }}" class="px-6 py-20 text-center text-slate-400">
                                <p class="text-lg">Tidak ada data transaksi pada periode ini</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($recap['classes']) > 0)
                <tfoot class="sticky bottom-0 bg-white font-bold border-t-2 border-slate-300">
                    <tr class="bg-slate-100">
                        <td class="px-6 py-4 text-slate-800 text-sm font-black border border-slate-200">TOTAL SELURUH</td>
                        @foreach($recap['dates'] as $date)
                            @php 
                                $colTotal = 0;
                                foreach($recap['classes'] as $c) {
                                    foreach($c['students'] as $s) {
                                        $colTotal += ($s['history'][$date] ?? 0);
                                    }
                                }
                            @endphp
                            <td class="px-2 py-4 text-center border border-slate-200 text-sm {{ $colTotal > 0 ? 'text-emerald-700' : ($colTotal < 0 ? 'text-rose-700' : 'text-slate-400') }}">
                                {{ $colTotal != 0 ? ($colTotal > 0 ? number_format($colTotal, 0, ',', '.') : '(' . number_format(abs($colTotal), 0, ',', '.') . ')') : '-' }}
                            </td>
                        @endforeach
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
