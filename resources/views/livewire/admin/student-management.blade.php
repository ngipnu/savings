<div>
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a29] tracking-tight">Manajemen Siswa</h1>
            <p class="text-slate-500 mt-1">Kelola data siswa dan akun mereka</p>
        </div>
        <div class="flex gap-3">
            <button wire:click="openImportModal" class="px-4 py-3 md:px-6 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-all shadow-lg shadow-blue-900/20">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                    <span class="hidden md:inline">Import Excel</span>
                </span>
            </button>
            <button wire:click="openModal" class="px-4 py-3 md:px-6 bg-[#1e3a29] text-white rounded-xl font-semibold hover:bg-[#2a4d38] transition-all shadow-lg shadow-emerald-900/20">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    <span class="hidden md:inline">Tambah Siswa</span>
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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input wire:model.live="search" type="text" placeholder="Cari nama, NIS, atau email..." class="px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
            <select wire:model.live="filterClass" class="px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                <option value="">Semua Kelas</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                        <th class="px-3 py-3 md:px-6 md:py-4 hidden md:table-cell">NIS</th>
                        <th class="px-3 py-3 md:px-6 md:py-4">Nama</th>
                        <th class="px-3 py-3 md:px-6 md:py-4">Kelas</th>
                        <th class="px-3 py-3 md:px-6 md:py-4 hidden md:table-cell">Email</th>
                        <th class="px-3 py-3 md:px-6 md:py-4 hidden md:table-cell">No. HP</th>
                        <th class="px-3 py-3 md:px-6 md:py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $student)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-3 py-3 md:px-6 md:py-4 hidden md:table-cell">
                            <span class="font-mono text-xs md:text-sm font-bold text-[#1e3a29]">{{ $student->student_id }}</span>
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4">
                            <div class="font-bold text-slate-800 text-sm md:text-base">{{ $student->name }}</div>
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4">
                            <span class="px-2 py-1 md:px-3 md:py-1 bg-lime-100 text-[#1e3a29] rounded-lg text-xs md:text-sm font-bold">
                                {{ $student->classRoom ? $student->classRoom->name : '-' }}
                            </span>
                        </td>
                        <td class="px-3 py-3 md:px-6 md:py-4 text-xs md:text-sm text-slate-600 hidden md:table-cell">{{ $student->email }}</td>
                        <td class="px-3 py-3 md:px-6 md:py-4 text-xs md:text-sm text-slate-600 hidden md:table-cell">{{ $student->phone ?? '-' }}</td>
                        <td class="px-3 py-3 md:px-6 md:py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.student.print-account', $student->id) }}" target="_blank" class="px-2 py-1 md:px-3 md:py-1.5 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-100 transition-colors text-xs md:text-sm font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.618 0-1.11-.512-1.12-1.125L6.34 18m11.32 0h-11.32m1.12-12h9.44c1.18 0 2.164.91 2.201 2.09.037.332.052.668.052 1.01s-.015.678-.052 1.01c-.037 1.18-.91 2.164-2.09 2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                    <span class="hidden md:inline font-bold">Cetak Akun</span>
                                </a>
                                <button wire:click="edit({{ $student->id }})" class="px-2 py-1 md:px-3 md:py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-xs md:text-sm font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:hidden">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    <span class="hidden md:inline font-bold">Edit</span>
                                </button>
                                <button wire:click="resetPassword({{ $student->id }})" wire:confirm="Yakin ingin mereset password siswa ini menjadi 12345678?" class="px-2 py-1 md:px-3 md:py-1.5 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-100 transition-colors text-xs md:text-sm font-medium" title="Reset Password ke 12345678">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 md:hidden">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                                    </svg>
                                    <span class="hidden md:inline font-bold">Reset Pass</span>
                                </button>
                                <button wire:click="delete({{ $student->id }})" wire:confirm="Yakin ingin menghapus siswa ini?" class="px-2 py-1 md:px-3 md:py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-xs md:text-sm font-medium">
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
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            Belum ada data siswa
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $students->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-start justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-6 md:p-8 my-8 relative">
            <h2 class="text-2xl font-bold text-[#1e3a29] mb-6">
                {{ $editMode ? 'Edit Data Siswa' : 'Tambah Siswa Baru' }}
            </h2>

            <form wire:submit="save" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nomor Induk Siswa (NIS)</label>
                        <input wire:model="student_id" type="text" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="2024001">
                        @error('student_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                        <input wire:model="name" type="text" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="Ahmad Siswa">
                        @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input wire:model="email" type="email" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="ahmad@student.com">
                        @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Password {{ $editMode ? '(kosongkan jika tidak diubah)' : '' }}</label>
                        <input wire:model="password" type="password" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="••••••••">
                        @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kelas</label>
                        <select wire:model="class_room_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none disabled:bg-slate-100 disabled:text-slate-500" @if(auth()->user()->role === 'wali_kelas') disabled @endif>
                            <option value="">Pilih Kelas</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('class_room_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">No. HP</label>
                        <input wire:model="phone" type="text" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="08123456789">
                        @error('phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Parent Information Section -->
                <div class="col-span-full border-t border-slate-200 pt-6 mt-2">
                    <h3 class="text-lg font-bold text-[#1e3a29] mb-4">Data Orang Tua / Wali</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Orang Tua</label>
                            <input wire:model="parent_name" type="text" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="Budi Santoso">
                            @error('parent_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">No. HP Orang Tua</label>
                            <input wire:model="parent_phone" type="text" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="08123456789">
                            @error('parent_phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Email Orang Tua</label>
                            <input wire:model="parent_email" type="email" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="budi@email.com">
                            @error('parent_email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                    <textarea wire:model="address" rows="3" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="Jl. Merdeka No. 1"></textarea>
                    @error('address') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" wire:click="closeModal" class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition-colors font-medium">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-[#1e3a29] text-white rounded-lg hover:bg-[#2a4d38] transition-colors font-medium flex justify-center items-center gap-2" wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $editMode ? 'Perbarui' : 'Simpan' }}</span>
                        <span wire:loading>Menyimpan...</span>
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
            <h2 class="text-2xl font-bold text-[#1e3a29] mb-6">Import Data Siswa dari Excel</h2>

            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="font-bold text-blue-900">Format Excel yang Diperlukan:</h4>
                    <a href="{{ route('admin.template.student') }}" class="text-xs px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M12 9.75l-3 3m0 0l3 3m-3-3H21" />
                        </svg>
                        Download Template
                    </a>
                </div>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• <strong>nama</strong> - Nama lengkap siswa (wajib)</li>
                    <li>• <strong>email</strong> - Email siswa (wajib, unique)</li>
                    <li>• <strong>nis</strong> - Nomor Induk Siswa (wajib, unique)</li>
                    <li>• <strong>password</strong> - Password (opsional, default: password)</li>
                    <li>• <strong>class_room_id</strong> - ID Kelas (opsional)</li>
                    <li>• <strong>no_hp</strong> - Nomor HP siswa (opsional)</li>
                    <li>• <strong>alamat</strong> - Alamat siswa (opsional)</li>
                    <li>• <strong>nama_orang_tua</strong> - Nama orang tua (opsional)</li>
                    <li>• <strong>no_hp_orang_tua</strong> - No HP orang tua (opsional)</li>
                    <li>• <strong>email_orang_tua</strong> - Email orang tua (opsional)</li>
                </ul>
            </div>

            <form wire:submit="import" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pilih File Excel</label>
                    <input wire:model="import_file" type="file" accept=".xlsx,.xls,.csv" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                    @error('import_file') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    <div wire:loading wire:target="import_file" class="text-xs text-blue-600 mt-1">Mengupload file...</div>
                    <p class="text-xs text-slate-500 mt-2">Format: .xlsx (Disarankan), .xls, .csv (Max: 2MB)</p>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" wire:click="closeImportModal" class="flex-1 px-4 py-2.5 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition-colors font-medium">
                        Batal
                    </button>
                    <button type="submit" 
                        class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center gap-2"
                        wire:loading.attr="disabled"
                        wire:target="import_file, import">
                        <span wire:loading.remove wire:target="import_file, import">Import Data</span>
                        <span wire:loading wire:target="import_file">Mengupload...</span>
                        <span wire:loading wire:target="import">Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
