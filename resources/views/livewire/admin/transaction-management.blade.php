<div>
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a29] tracking-tight">Manajemen Transaksi</h1>
            <p class="text-slate-500 mt-1">Kelola transaksi setoran dan penarikan tabungan</p>
        </div>
        <div class="flex gap-3">
            <button wire:click="openImportModal" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-all shadow-lg shadow-blue-900/20">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                    Import Excel
                </span>
            </button>
            <button wire:click="openModal" class="px-6 py-3 bg-[#1e3a29] text-white rounded-xl font-semibold hover:bg-[#2a4d38] transition-all shadow-lg shadow-emerald-900/20">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Tambah Transaksi
                </span>
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="mb-6 bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input wire:model.live="search" type="text" placeholder="Cari nama atau NIS siswa..." class="px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
            <select wire:model.live="filterType" class="px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                <option value="">Semua Tipe</option>
                <option value="deposit">Setoran</option>
                <option value="withdrawal">Penarikan</option>
            </select>
            <select wire:model.live="filterStatus" class="px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Disetujui</option>
                <option value="rejected">Ditolak</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
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
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transactions as $transaction)
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
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                @if($transaction->status === 'pending')
                                    <button wire:click="approve({{ $transaction->id }})" class="px-3 py-1.5 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-100 transition-colors text-sm font-medium">
                                        Setujui
                                    </button>
                                    <button wire:click="reject({{ $transaction->id }})" class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">
                                        Tolak
                                    </button>
                                @endif
                                <button wire:click="edit({{ $transaction->id }})" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                                    Edit
                                </button>
                                <button wire:click="delete({{ $transaction->id }})" wire:confirm="Yakin ingin menghapus transaksi ini?" class="px-3 py-1.5 bg-slate-50 text-slate-600 rounded-lg hover:bg-slate-100 transition-colors text-sm font-medium">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            Belum ada transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $transactions->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-8 my-8">
            <h2 class="text-2xl font-bold text-[#1e3a29] mb-6">
                {{ $editMode ? 'Edit Transaksi' : 'Tambah Transaksi Baru' }}
            </h2>

            <form wire:submit="save" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Siswa</label>
                        <select wire:model="user_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                            <option value="">Pilih Siswa</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->student_id }})</option>
                            @endforeach
                        </select>
                        @error('user_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
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

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                        <select wire:model="status" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                            <option value="pending">Pending</option>
                            <option value="approved">Disetujui</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                        @error('status') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
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
                        {{ $editMode ? 'Perbarui' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Import Modal -->
    @if($showImportModal)
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8">
            <h2 class="text-2xl font-bold text-[#1e3a29] mb-6">Import Data Transaksi dari Excel</h2>

            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h4 class="font-bold text-blue-900 mb-2">Format Excel yang Diperlukan:</h4>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• <strong>nis</strong> - NIS siswa (wajib)</li>
                    <li>• <strong>jenis_tabungan</strong> - Nama produk tabungan (wajib)</li>
                    <li>• <strong>tipe</strong> - setoran/penarikan (wajib)</li>
                    <li>• <strong>jumlah</strong> - Nominal transaksi (wajib)</li>
                    <li>• <strong>tanggal</strong> - Tanggal transaksi (wajib)</li>
                    <li>• <strong>keterangan</strong> - Keterangan (opsional)</li>
                    <li>• <strong>status</strong> - pending/approved/rejected (opsional, default: approved)</li>
                </ul>
            </div>

            <form wire:submit="import" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pilih File Excel</label>
                    <input wire:model="importFile" type="file" accept=".xlsx,.xls,.csv" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                    @error('importFile') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    <p class="text-xs text-slate-500 mt-2">Format: .xlsx, .xls, .csv (Max: 2MB)</p>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" wire:click="closeImportModal" class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition-colors font-medium">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Import Data
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
