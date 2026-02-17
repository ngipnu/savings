<div>
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a29] tracking-tight">Rekap Tabungan Siswa</h1>
            <p class="text-slate-500 mt-1">Detail mutasi dan saldo tabungan siswa</p>
        </div>
        <div class="flex gap-3">
            <a href="javascript:history.back()" class="px-4 py-3 md:px-6 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition-all shadow-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span class="hidden md:inline">Kembali</span>
            </a>
            <button wire:click="openModal" class="px-4 py-3 md:px-6 bg-lime-500 text-white rounded-xl font-semibold hover:bg-lime-600 transition-all shadow-lg shadow-lime-900/20 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                <span class="hidden md:inline">Transaksi Baru</span>
            </button>
            <a href="{{ route('admin.student.print-account', $student->id) }}" target="_blank" class="px-4 py-3 md:px-6 bg-[#1e3a29] text-white rounded-xl font-semibold hover:bg-[#2a4d38] transition-all shadow-lg shadow-emerald-900/20 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                </svg>
                <span class="hidden md:inline">Cetak Tabungan</span>
            </a>
        </div>
    </div>

    <!-- Floating Notifications / Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl shadow-sm flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 mt-0.5 text-emerald-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
            <div>
                <p class="font-bold text-sm text-emerald-900">Berhasil!</p>
                <p class="text-sm opacity-90">{{ session('message') }}</p>
            </div>
        </div>
    @endif

    <!-- Student Info Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 mb-6">
        <div class="flex flex-col md:flex-row gap-6 items-start md:items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-lime-100 text-lime-600 rounded-2xl flex items-center justify-center text-2xl font-bold shadow-inner">
                    {{ substr($student->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">{{ $student->name }}</h2>
                    <div class="flex items-center gap-3 text-sm text-slate-500 mt-1">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" /></svg>
                            NIS: {{ $student->student_id }}
                        </span>
                        <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            Kelas: {{ $student->classRoom->name ?? '-' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Summary Stats Mini -->
            <div class="flex gap-4 w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
                <div class="bg-emerald-50 px-4 py-3 rounded-xl min-w-[140px]">
                    <div class="text-xs font-semibold text-emerald-600 uppercase mb-1">Total Setoran</div>
                    <div class="text-lg font-bold text-emerald-700">Rp {{ number_format($totalDeposit, 0, ',', '.') }}</div>
                </div>
                <div class="bg-rose-50 px-4 py-3 rounded-xl min-w-[140px]">
                    <div class="text-xs font-semibold text-rose-600 uppercase mb-1">Total Penarikan</div>
                    <div class="text-lg font-bold text-rose-700">Rp {{ number_format($totalWithdrawal, 0, ',', '.') }}</div>
                </div>
                <div class="bg-[#1e3a29] px-4 py-3 rounded-xl min-w-[140px] shadow-lg shadow-emerald-900/20">
                    <div class="text-xs font-semibold text-lime-400 uppercase mb-1">Saldo Akhir</div>
                    <div class="text-xl font-bold text-white">Rp {{ number_format($balance, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction History Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-slate-800">Riwayat Mutasi</h3>
            
            <select wire:model.live="perPage" class="px-3 py-1.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none text-sm text-slate-600 bg-slate-50">
                <option value="10">10 Baris</option>
                <option value="25">25 Baris</option>
                <option value="50">50 Baris</option>
                <option value="100">100 Baris</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Tipe Transaksi</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4">Petugas</th>
                        <th class="px-6 py-4 text-right">Debit / Kredit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4 text-sm text-slate-600 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-700">
                            {{ $transaction->savingType->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @if($transaction->type === 'deposit')
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold flex items-center gap-1.5 w-max">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                                    Setor
                                </span>
                            @else
                                <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-lg text-xs font-bold flex items-center gap-1.5 w-max">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                                    Tarik
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($transaction->status === 'approved')
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-bold">Approved</span>
                            @elseif($transaction->status === 'pending')
                                <span class="px-2 py-1 bg-amber-100 text-amber-700 rounded-lg text-xs font-bold">Pending</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-bold">Rejected</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 max-w-xs truncate" title="{{ $transaction->description }}">
                            {{ $transaction->description ?: '-' }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">
                            {{ $transaction->approver->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-bold text-sm md:text-base {{ $transaction->type === 'deposit' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $transaction->type === 'deposit' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                </div>
                                <p class="text-slate-500 font-medium">Bulus ada riwayat transaksi</p>
                                <p class="text-sm text-slate-400 mt-1">Siswa ini belum memiliki transaksi apapun.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>

    <!-- Modal Tambah Transaksi -->
    @if($showModal)
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-start justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-6 md:p-8 my-8 relative">
            <h2 class="text-2xl font-bold text-[#1e3a29] mb-6">Tambah Transaksi Siswa</h2>

            <form wire:submit="saveTransaction" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Siswa</label>
                        <input type="text" disabled value="{{ $student->name }}" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg bg-slate-100 text-slate-500 outline-none font-bold">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Produk Tabungan</label>
                        <select wire:model="saving_type_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                            <option value="">Pilih Produk</option>
                            @foreach($savingTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('saving_type_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tipe Transaksi</label>
                        <select wire:model="type" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                            <option value="">Pilih Tipe</option>
                            <option value="deposit">Setoran</option>
                            <option value="withdrawal">Penarikan</option>
                        </select>
                        @error('type') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah (Rp)</label>
                        <input wire:model="amount" type="number" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="50000">
                        @error('amount') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal</label>
                        <input wire:model="date" type="date" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                        @error('date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    @if(!in_array(auth()->user()->role, ['operator', 'wali_kelas']))
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                        <select wire:model="status" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                            <option value="pending">Pending</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                        @error('status') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Keterangan</label>
                    <textarea wire:model="description" rows="3" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="Keterangan transaksi"></textarea>
                    @error('description') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" wire:click="closeModal" class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition-colors font-medium">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-[#1e3a29] text-white rounded-lg hover:bg-[#2a4d38] transition-colors font-medium">
                        Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
