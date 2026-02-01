<div>
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a29] tracking-tight">Akun Pengelola</h1>
            <p class="text-slate-500 mt-1">Kelola akun super admin, wali kelas, dan operator</p>
        </div>
        <button wire:click="openModal" class="px-6 py-3 bg-[#1e3a29] text-white rounded-xl font-semibold hover:bg-[#2a4d38] transition-all shadow-lg shadow-emerald-900/20">
            <span class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Pengelola
            </span>
        </button>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search & Filter -->
    <div class="mb-6 bg-white rounded-xl p-6 shadow-sm border border-slate-100">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input wire:model.live="search" type="text" placeholder="Cari nama atau email..." class="px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
            <select wire:model.live="filterRole" class="px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                <option value="">Semua Role</option>
                <option value="super_admin">Super Admin</option>
                <option value="wali_kelas">Wali Kelas</option>
                <option value="operator">Operator</option>
            </select>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr class="text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">No. HP</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($managers as $manager)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800">{{ $manager->name }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $manager->email }}</td>
                        <td class="px-6 py-4">
                            @if($manager->role === 'super_admin')
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-lg text-sm font-bold">Super Admin</span>
                            @elseif($manager->role === 'wali_kelas')
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-bold">Wali Kelas</span>
                            @else
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-sm font-bold">Operator</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $manager->phone ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <button wire:click="edit({{ $manager->id }})" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-sm font-medium">
                                    Edit
                                </button>
                                <button wire:click="delete({{ $manager->id }})" wire:confirm="Yakin ingin menghapus akun ini?" class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-sm font-medium">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            Belum ada data pengelola
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $managers->links() }}
        </div>
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8">
            <h2 class="text-2xl font-bold text-[#1e3a29] mb-6">
                {{ $editMode ? 'Edit Akun Pengelola' : 'Tambah Akun Pengelola' }}
            </h2>

            <form wire:submit="save" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                    <input wire:model="name" type="text" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="Budi Santoso">
                    @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input wire:model="email" type="email" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="budi@sekolah.sch.id">
                    @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Password {{ $editMode ? '(kosongkan jika tidak diubah)' : '' }}</label>
                    <input wire:model="password" type="password" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="••••••••">
                    @error('password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Role</label>
                    <select wire:model="role" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                        <option value="">Pilih Role</option>
                        <option value="super_admin">Super Admin</option>
                        <option value="wali_kelas">Wali Kelas</option>
                        <option value="operator">Operator</option>
                    </select>
                    @error('role') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">No. HP</label>
                    <input wire:model="phone" type="text" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="08123456789">
                    @error('phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
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
