<div>
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a29] tracking-tight">Manajemen Tahun Akademik</h1>
            <p class="text-slate-500 mt-1">Kelola tahun ajaran sekolah</p>
        </div>
        <button wire:click="openModal" class="px-4 py-3 md:px-6 bg-[#1e3a29] text-white rounded-xl font-semibold hover:bg-[#2a4d38] transition-all shadow-lg shadow-emerald-900/20">
            <span class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                <span class="hidden md:inline">Tambah Tahun Akademik</span>
            </span>
        </button>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl">
            {{ session('message') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                        <th class="px-3 py-3 md:px-6 md:py-4">Tahun Akademik</th>
                        <th class="px-3 py-3 md:px-6 md:py-4 hidden md:table-cell">Tanggal Mulai</th>
                        <th class="px-3 py-3 md:px-6 md:py-4 hidden md:table-cell">Tanggal Selesai</th>
                        <th class="px-3 py-3 md:px-6 md:py-4">Status</th>
                        <th class="px-3 py-3 md:px-6 md:py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($years as $year)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-3 py-3 md:px-6 md:py-4">
                            <div class="font-bold text-[#1e3a29] text-sm md:text-base">{{ $year->name }}</div>
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4 text-xs md:text-sm text-slate-600 hidden md:table-cell">
                            {{ $year->start_date->format('d M Y') }}
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4 text-xs md:text-sm text-slate-600 hidden md:table-cell">
                            {{ $year->end_date->format('d M Y') }}
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4">
                            @if($year->is_active)
                                <span class="px-2 py-1 md:px-3 md:py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs md:text-sm font-bold">Aktif</span>
                            @else
                                <span class="px-2 py-1 md:px-3 md:py-1 bg-slate-100 text-slate-600 rounded-lg text-xs md:text-sm font-bold">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4">
                            <div class="flex gap-2">
                                @if(!$year->is_active)
                                    <button wire:click="setActive({{ $year->id }})" class="px-2 py-1 md:px-3 md:py-1.5 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-100 transition-colors text-xs md:text-sm font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:hidden">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                        </svg>
                                        <span class="hidden md:inline">Aktifkan</span>
                                    </button>
                                @endif
                                <button wire:click="edit({{ $year->id }})" class="px-2 py-1 md:px-3 md:py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-xs md:text-sm font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:hidden">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    <span class="hidden md:inline">Edit</span>
                                </button>
                                <button wire:click="delete({{ $year->id }})" wire:confirm="Yakin ingin menghapus tahun akademik ini?" class="px-2 py-1 md:px-3 md:py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-xs md:text-sm font-medium">
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
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            Belum ada tahun akademik
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $years->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8">
            <h2 class="text-2xl font-bold text-[#1e3a29] mb-6">
                {{ $editMode ? 'Edit Tahun Akademik' : 'Tambah Tahun Akademik' }}
            </h2>

            <form wire:submit="save" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Tahun Akademik</label>
                    <input wire:model="name" type="text" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="2024/2025">
                    @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Mulai</label>
                    <input wire:model="start_date" type="date" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                    @error('start_date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Selesai</label>
                    <input wire:model="end_date" type="date" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                    @error('end_date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center gap-3">
                    <input wire:model="is_active" type="checkbox" id="is_active" class="w-5 h-5 text-[#1e3a29] border-slate-300 rounded focus:ring-lime-400">
                    <label for="is_active" class="text-sm font-medium text-slate-700">Set sebagai tahun akademik aktif</label>
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
</div>
