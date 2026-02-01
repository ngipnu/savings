<div class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gradient-to-br from-emerald-50 to-slate-100 p-6">
    <!-- Background Accents -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-300 rounded-full blur-3xl opacity-20 -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-amber-200 rounded-full blur-3xl opacity-20 translate-y-1/2 -translate-x-1/2"></div>

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 relative z-10 border border-white/50 backdrop-blur-md">
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 mb-4 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
            </a>
            <h2 class="text-2xl font-bold text-slate-800">Selamat Datang Kembali!</h2>
            <p class="text-slate-500 text-sm mt-2">Silakan login untuk mengakses akun Anda.</p>
        </div>

        <form wire:submit="login" class="space-y-6">
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                <div class="relative">
                    @error('email')
                        <input wire:model="email" type="email" id="email" class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none text-slate-700 bg-slate-50 focus:bg-white border-red-500 ring-red-100" placeholder="nama@sekolah.sch.id">
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @else
                        <input wire:model="email" type="email" id="email" class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none text-slate-700 bg-slate-50 focus:bg-white border-slate-200" placeholder="nama@sekolah.sch.id">
                    @enderror
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                <div class="relative">
                    @error('password')
                        <input wire:model="password" type="password" id="password" class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none text-slate-700 bg-slate-50 focus:bg-white border-red-500 ring-red-100" placeholder="••••••••">
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @else
                        <input wire:model="password" type="password" id="password" class="w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all outline-none text-slate-700 bg-slate-50 focus:bg-white border-slate-200" placeholder="••••••••">
                    @enderror
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 bg-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-xl transition-all duration-300 transform active:scale-[0.98]">
                <span wire:loading.remove>Masuk Sekarang</span>
                <span wire:loading>Memproses...</span>
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="/" class="text-sm text-slate-400 hover:text-emerald-600 transition">Kembali ke Beranda</a>
        </div>
    </div>
</div>
