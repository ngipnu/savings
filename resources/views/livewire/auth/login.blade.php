<div class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gradient-to-br from-lime-50 to-slate-100 p-6">
    <!-- Background Accents -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-lime-300 rounded-full blur-3xl opacity-20 -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-[#1e3a29] rounded-full blur-3xl opacity-10 translate-y-1/2 -translate-x-1/2 pointer-events-none"></div>

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 relative z-10 border border-white/50 backdrop-blur-md">
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center justify-center mb-4">
                <img src="{{ asset('logo_round.png') }}" alt="TASIA Logo" class="w-20 h-20 rounded-2xl shadow-lg object-cover">
            </a>
            <h2 class="text-2xl font-bold text-[#1e3a29]">Selamat Datang di TASIA!</h2>
            <p class="text-slate-500 text-sm mt-2">Tabungan Siswa An Nadzir - Silakan login untuk mengakses akun Anda.</p>
        </div>

        <form wire:submit.prevent="login" class="space-y-6">
            <div>
                <label for="login" class="block text-sm font-medium text-slate-700 mb-2">Email / NIS</label>
                <div class="relative">
                    <input wire:model="login" type="text" id="login" 
                        @class([
                            'w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-lime-400 focus:border-lime-400 transition-all outline-none text-slate-700 bg-slate-50 focus:bg-white',
                            'border-red-500 ring-red-100' => $errors->has('login'),
                            'border-slate-200' => !$errors->has('login'),
                        ])
                        placeholder="Masukkan Email atau NIS">
                    @error('login')
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                <div class="relative">
                    <input wire:model="password" type="password" id="password" 
                        @class([
                            'w-full px-4 py-3 rounded-xl border focus:ring-2 focus:ring-lime-400 focus:border-lime-400 transition-all outline-none text-slate-700 bg-slate-50 focus:bg-white',
                            'border-red-500 ring-red-100' => $errors->has('password'),
                            'border-slate-200' => !$errors->has('password'),
                        ])
                        placeholder="••••••••">
                    @error('password')
                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 bg-[#1e3a29] text-white font-bold rounded-xl shadow-lg shadow-[#1e3a29]/20 hover:bg-[#2a4d38] hover:shadow-xl transition-all duration-300 transform active:scale-[0.98]">
                <span wire:loading.remove>Masuk Sekarang</span>
                <span wire:loading>Memproses...</span>
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="/" class="text-sm text-slate-400 hover:text-[#1e3a29] transition">Kembali ke Beranda</a>
        </div>
    </div>
</div>
