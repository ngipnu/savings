<div>
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-[#1e3a29] tracking-tight">Profile Saya</h1>
            <p class="text-slate-500 mt-1">Kelola informasi pribadi dan keamanan akun</p>
        </div>
        <a href="{{ route('wali-kelas.dashboard') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-colors font-medium flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="space-y-6 max-w-3xl">
        <!-- Success Messages -->
        @if (session()->has('message'))
            <div class="p-4 bg-lime-50 border border-lime-200 text-[#1e3a29] rounded-xl flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-lime-600">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('password_message'))
            <div class="p-4 bg-lime-50 border border-lime-200 text-[#1e3a29] rounded-xl flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-lime-600">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
                {{ session('password_message') }}
            </div>
        @endif

        <!-- Profile Information -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <h2 class="text-xl font-bold text-[#1e3a29] mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-lime-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                Informasi Pribadi
            </h2>
            
            <form wire:submit="updateProfile" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                        <input wire:model="name" type="text" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none transition-all">
                        @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input wire:model="email" type="email" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none transition-all">
                        @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">No. Telepon</label>
                        <input wire:model="phone" type="text" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none transition-all" placeholder="08xx-xxxx-xxxx">
                        @error('phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                        <textarea wire:model="address" rows="3" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none transition-all" placeholder="Alamat lengkap"></textarea>
                        @error('address') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-[#1e3a29] text-white font-semibold rounded-xl hover:bg-[#2a4d38] transition-colors shadow-lg shadow-emerald-900/20">
                        <span wire:loading.remove>Simpan Perubahan</span>
                        <span wire:loading>Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
            <h2 class="text-xl font-bold text-[#1e3a29] mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-lime-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
                Ubah Password
            </h2>
            
            <form wire:submit="updatePassword" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Password Saat Ini</label>
                        <input wire:model="current_password" type="password" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none transition-all">
                        @error('current_password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Password Baru</label>
                        <input wire:model="new_password" type="password" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none transition-all">
                        @error('new_password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password Baru</label>
                        <input wire:model="new_password_confirmation" type="password" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none transition-all">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-colors shadow-lg shadow-red-900/20">
                        <span wire:loading.remove>Ubah Password</span>
                        <span wire:loading>Mengubah...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
