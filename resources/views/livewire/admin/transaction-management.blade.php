<div>
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a29] tracking-tight">Manajemen Transaksi</h1>
            <p class="text-slate-500 mt-1">Kelola transaksi setoran dan penarikan tabungan</p>
        </div>
        <div class="flex gap-3">
             @if(auth()->user()->role === 'super_admin' && \App\Models\Transaction::where('status', 'pending')->exists())
                <button wire:click="approveAll" wire:confirm="Yakin ingin menyetujui SEMUA transaksi pending?" class="px-4 py-3 md:px-6 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-900/20">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="hidden md:inline">Setujui Semua</span>
                    </span>
                </button>
            @endif
            <button wire:click="openImportModal" class="px-4 py-3 md:px-6 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-all shadow-lg shadow-blue-900/20">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                    <span class="hidden md:inline">Import Excel</span>
                </span>
            </button>
            <button wire:click="openModal" class="px-4 py-3 md:px-6 bg-[#1e3a29] text-white rounded-xl font-semibold hover:bg-[#2a4d38] transition-all shadow-lg shadow-emerald-900/20">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    <span class="hidden md:inline">Tambah Transaksi</span>
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
                        <th class="px-3 py-3 md:px-6 md:py-4 hidden md:table-cell">Tanggal</th>
                        <th class="px-3 py-3 md:px-6 md:py-4">Siswa</th>
                        <th class="px-3 py-3 md:px-6 md:py-4 hidden md:table-cell">Produk</th>
                        <th class="px-3 py-3 md:px-6 md:py-4">Tipe</th>
                        <th class="px-3 py-3 md:px-6 md:py-4">Jumlah</th>
                        <th class="px-3 py-3 md:px-6 md:py-4">Status</th>
                        <th class="px-3 py-3 md:px-6 md:py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-3 py-3 md:px-6 md:py-4 text-xs md:text-sm text-slate-600 hidden md:table-cell">
                            {{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4">
                            <div class="font-bold text-slate-800 text-sm md:text-base">{{ $transaction->user->name }}</div>
                            <div class="text-[10px] md:text-xs text-slate-500">{{ $transaction->user->student_id }}</div>
                            <div class="md:hidden text-[10px] text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</div>
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4 text-xs md:text-sm text-slate-600 hidden md:table-cell">
                            {{ $transaction->savingType->name }}
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4">
                            @if($transaction->type === 'deposit')
                                <span class="px-2 py-1 md:px-3 md:py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs md:text-sm font-bold">Setor</span>
                            @else
                                <span class="px-2 py-1 md:px-3 md:py-1 bg-rose-100 text-rose-700 rounded-lg text-xs md:text-sm font-bold">Tarik</span>
                            @endif
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4">
                            <span class="font-bold text-[#1e3a29] text-sm md:text-base">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4">
                            @if($transaction->status === 'approved')
                                <span class="px-2 py-1 md:px-3 md:py-1 bg-blue-100 text-blue-700 rounded-lg text-xs md:text-sm font-bold">Oke</span>
                            @elseif($transaction->status === 'pending')
                                <span class="px-2 py-1 md:px-3 md:py-1 bg-amber-100 text-amber-700 rounded-lg text-xs md:text-sm font-bold">Wait</span>
                            @else
                                <span class="px-2 py-1 md:px-3 md:py-1 bg-red-100 text-red-700 rounded-lg text-xs md:text-sm font-bold">Fail</span>
                            @endif
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.transaction.receipt', $transaction->id) }}" target="_blank" class="px-2 py-1 md:px-3 md:py-1.5 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition-colors text-xs md:text-sm font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:hidden">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                    </svg>
                                    <span class="hidden md:inline">Cetak</span>
                                </a>
                                @if($transaction->status === 'pending' && auth()->user()->role === 'super_admin')
                                    <button wire:click="approve({{ $transaction->id }})" class="px-2 py-1 md:px-3 md:py-1.5 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-100 transition-colors text-xs md:text-sm font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:hidden">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        <span class="hidden md:inline">Setujui</span>
                                    </button>
                                    <button wire:click="reject({{ $transaction->id }})" class="px-2 py-1 md:px-3 md:py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-xs md:text-sm font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:hidden">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        <span class="hidden md:inline">Tolak</span>
                                    </button>
                                @endif
                                <button wire:click="edit({{ $transaction->id }})" class="px-2 py-1 md:px-3 md:py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-xs md:text-sm font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:hidden">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    <span class="hidden md:inline">Edit</span>
                                </button>
                                <button wire:click="delete({{ $transaction->id }})" wire:confirm="Yakin ingin menghapus transaksi ini?" class="px-2 py-1 md:px-3 md:py-1.5 bg-slate-50 text-slate-600 rounded-lg hover:bg-slate-100 transition-colors text-xs md:text-sm font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:hidden">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                    <span class="hidden md:inline">Hapus</span>
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
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-start justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-6 md:p-8 my-8 relative">
            <h2 class="text-2xl font-bold text-[#1e3a29] mb-6">
                {{ $editMode ? 'Edit Transaksi' : 'Tambah Transaksi Baru' }}
            </h2>

            <form wire:submit="save" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div wire:ignore>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Siswa</label>
                        <select x-data="{ choice: null }" x-init="
                            choice = new Choices($el, {
                                searchEnabled: true,
                                itemSelectText: '',
                                placeholder: true,
                                placeholderValue: 'Pilih Siswa',
                                shouldSort: false,
                            });
                            $el.addEventListener('change', function(event) {
                                $wire.set('user_id', event.target.value);
                            });
                            $wire.on('transaction-saved', () => {
                                choice.removeActiveItems();
                                choice.setChoiceByValue('');
                            });
                            $wire.on('set-student-choice', (data) => {
                                choice.setChoiceByValue(data.userId.toString());
                            });
                        " class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
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

                    @if(auth()->user()->role !== 'operator')
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
                        {{ $editMode ? 'Perbarui' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Import Modal -->
    @if($showImportModal)
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-start justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 md:p-8 relative">
            <h2 class="text-2xl font-bold text-[#1e3a29] mb-6">Import Data Transaksi dari Excel</h2>

            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="font-bold text-blue-900">Format Excel yang Diperlukan:</h4>
                    <a href="{{ route('admin.template.transaction') }}" class="text-xs px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M12 9.75l-3 3m0 0l3 3m-3-3H21" />
                        </svg>
                        Download Template
                    </a>
                </div>
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
                    <p class="text-xs text-slate-500 mt-2">Format: .xlsx (Disarankan), .xls, .csv (Max: 2MB)</p>
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
