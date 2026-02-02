<div class="min-h-screen bg-slate-50 pb-20">
    <!-- Mobile Header -->
    <div class="bg-white px-6 py-6 shadow-sm sticky top-0 z-20 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <a href="/student/dashboard" class="p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-slate-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-[#1e3a29]">Profile Saya</h1>
                <p class="text-xs text-slate-500">Kelola informasi pribadi Anda</p>
            </div>
        </div>
    </div>

    <div class="p-6 space-y-6 max-w-lg mx-auto">
        <!-- Success Messages -->
        @if (session()->has('force_password_change'))
            <div class="p-6 bg-rose-50 border-2 border-rose-200 text-rose-800 rounded-2xl shadow-lg animate-bounce">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-6 h-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h3 class="font-bold text-lg">Keamanan Akun Terdeteksi!</h3>
                </div>
                <p class="text-sm leading-relaxed">
                    Anda masih menggunakan <strong>password default</strong>. Demi keamanan tabungan Anda, silakan segera ubah password Anda menjadi kombinasi yang lebih kuat di form bawah ini.
                </p>
                <div class="mt-4 text-xs font-bold text-rose-600 uppercase tracking-widest">
                    Gulir kebawah untuk "Ubah Password" ↓
                </div>
            </div>
        @endif

        @if (session()->has('message'))
            <div class="p-4 bg-lime-50 border border-lime-200 text-[#1e3a29] rounded-xl">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('password_message'))
            <div class="p-4 bg-lime-50 border border-lime-200 text-[#1e3a29] rounded-xl">
                {{ session('password_message') }}
            </div>
        @endif

        <!-- Profile Information -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-6">Informasi Pribadi</h2>
            
            <form wire:submit="updateProfile" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                    <input wire:model="name" type="text" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                    @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input wire:model="email" type="email" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                    @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">No. Telepon</label>
                    <input wire:model="phone" type="text" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="08xx-xxxx-xxxx">
                    @error('phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
                    <textarea wire:model="address" rows="3" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="Alamat lengkap"></textarea>
                    @error('address') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3 bg-[#1e3a29] text-white font-semibold rounded-xl hover:bg-[#2a4d38] transition-colors">
                        <span wire:loading.remove>Simpan Perubahan</span>
                        <span wire:loading>Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Parent Information -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-6">Informasi Orang Tua/Wali</h2>
            
            <form wire:submit="updateProfile" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Nama Orang Tua/Wali</label>
                    <input wire:model="parent_name" type="text" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                    @error('parent_name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">No. Telepon Orang Tua/Wali</label>
                    <input wire:model="parent_phone" type="text" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none" placeholder="08xx-xxxx-xxxx">
                    @error('parent_phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3 bg-[#1e3a29] text-white font-semibold rounded-xl hover:bg-[#2a4d38] transition-colors">
                        <span wire:loading.remove>Simpan Perubahan</span>
                        <span wire:loading>Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h2 class="text-lg font-bold text-slate-800 mb-6">Ubah Password</h2>
            
            <form wire:submit="updatePassword" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Password Saat Ini</label>
                    <input wire:model="current_password" type="password" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                    @error('current_password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Password Baru</label>
                    <input wire:model="new_password" type="password" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                    @error('new_password') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Password Baru</label>
                    <input wire:model="new_password_confirmation" type="password" class="w-full px-4 py-2.5 border border-slate-200 rounded-lg focus:ring-2 focus:ring-lime-400 focus:border-transparent outline-none">
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition-colors">
                        <span wire:loading.remove>Ubah Password</span>
                        <span wire:loading>Mengubah...</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="bg-lime-50 border border-lime-200 rounded-2xl p-4">
            <div class="flex gap-3">
                <svg class="w-5 h-5 text-[#1e3a29] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm text-slate-700">
                    <p class="font-semibold text-[#1e3a29] mb-1">Informasi Penting</p>
                    <p>Data yang Anda update akan tersimpan dan dapat dilihat oleh admin sekolah untuk keperluan administrasi.</p>
                </div>
            </div>
        </div>
    </div>
</div>
