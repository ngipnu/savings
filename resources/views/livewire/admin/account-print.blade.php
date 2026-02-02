<div class="max-w-xl mx-auto my-10 bg-white p-8 rounded-2xl shadow-xl border border-slate-200 print:shadow-none print:border-none print:m-0 print:max-w-none">
    <div class="text-center mb-8 border-b border-slate-200 pb-6">
        <img src="{{ asset('logo_round.png') }}" alt="Logo" class="w-16 h-16 mx-auto mb-3 object-cover rounded-full">
        <h1 class="text-2xl font-bold text-[#1e3a29]">TASIA</h1>
        <p class="text-slate-500 text-sm italic font-medium">Tabungan Siswa An Nadzir</p>
    </div>

    <div class="mb-10 text-center">
        <h2 class="text-xl font-bold text-slate-800 mb-2">Assalamu'alaikum, {{ $student->name }}</h2>
        <p class="text-slate-600 leading-relaxed">
            Selamat datang di aplikasi TASIA! <br>
            Terima kasih telah bergabung dan memiliki semangat untuk menabung bersama kami. 
            Semoga dengan menabung sejak dini, cita-citamu dapat terwujud dengan baik.
        </p>
    </div>

    <div class="bg-slate-50 rounded-2xl p-6 border border-dashed border-slate-300 mb-8">
        <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-4 text-center">Akses Akun Anda</p>
        
        <div class="space-y-4">
            <div class="flex justify-between items-center py-2 border-b border-slate-200">
                <span class="text-slate-500 text-sm">NIS (Username)</span>
                <span class="font-mono font-bold text-[#1e3a29]">{{ $student->student_id }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-slate-200">
                <span class="text-slate-500 text-sm">Email</span>
                <span class="font-medium text-slate-800">{{ $student->email }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-slate-200">
                <span class="text-slate-500 text-sm">Kelas</span>
                <span class="font-medium text-slate-800">{{ $student->classRoom ? $student->classRoom->name : '-' }}</span>
            </div>
            <div class="flex justify-between items-center py-2">
                <div class="text-left">
                    <span class="text-slate-500 text-sm block">Password Default</span>
                    <span class="text-[10px] text-slate-400 italic font-medium">*Silakan hubungi admin jika lupa password</span>
                </div>
                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-sm font-bold">Tersimpan Aman</span>
            </div>
        </div>
    </div>

    <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-100 mb-10">
        <p class="text-xs text-emerald-700 text-center leading-relaxed">
            <strong>Tips:</strong> Gunakan NIS atau Email untuk masuk ke dalam aplikasi. 
            Simpan data ini dengan baik dan jangan berikan kepada orang lain demi keamanan tabunganmu.
        </p>
    </div>

    <div class="text-center text-xs text-slate-400">
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
        <p class="mt-1">Aplikasi Tabungan Siswa An Nadzir - Masa Depan Cerah Dimulai dari Menabung</p>
    </div>

    <!-- Actions -->
    <div class="mt-10 text-center print:hidden space-x-4">
        <button onclick="window.print()" class="px-8 py-3 bg-[#1e3a29] text-white rounded-xl font-bold hover:bg-[#2a4d38] transition-all shadow-lg shadow-emerald-900/20 flex-inline items-center gap-2">
            <span class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak Sekarang
            </span>
        </button>
        <button onclick="window.close()" class="px-8 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold hover:bg-slate-200 transition-all">
            Tutup
        </button>
    </div>
</div>
