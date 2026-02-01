<div>
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a29] tracking-tight">Manajemen Siswa</h1>
            <p class="text-slate-500 mt-1">Kelola data siswa dan akun mereka</p>
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
                    Tambah Siswa
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
                        <th class="px-6 py-4">NIS</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Kelas</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">No. HP</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $student)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-mono text-sm font-bold text-[#1e3a29]">{{ $student->student_id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $student->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-lime-100 text-[#1e3a29] rounded-lg text-sm font-bold">
                                {{ $student->classRoom ? $student->classRoom->name : '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $student->email }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $student->phone ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <button wire:click="edit({{ $student->id }})" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                                    Edit
                                </button>
                                <button wire:click="delete({{ $student->id }})" wire:confirm="Yakin ingin menghapus siswa ini?" class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">
                                    Hapus
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
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-8 my-8">
            <h2 class="text-2xl font-bold text-[#1e3a29] mb-6">
                {{ $editMode ? 'Edit Data Siswa' : 'Tambah Siswa Baru' }}
            </h2>

            <form wire:submit="save" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">NIS</label>
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
                        <select wire:model="class_room_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
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
            <h2 class="text-2xl font-bold text-[#1e3a29] mb-6">Import Data Siswa dari Excel</h2>

            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h4 class="font-bold text-blue-900 mb-2">Format Excel yang Diperlukan:</h4>
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
