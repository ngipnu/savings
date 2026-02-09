<div class="space-y-8 print:space-y-0 text-center">
    @foreach($students as $student)
    <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-xl border border-slate-200 print:shadow-none print:border-none print:m-0 print:max-w-none print:break-after-always page-break">
        <div class="text-center mb-8 border-b border-slate-200 pb-6 print:pb-4 print:mb-4">
            <img src="{{ asset('logo_round.png') }}" alt="Logo" class="w-16 h-16 mx-auto mb-3 object-cover rounded-full print:w-12 print:h-12">
            <h1 class="text-2xl font-bold text-[#1e3a29] print:text-xl">TASIA</h1>
            <p class="text-slate-500 text-sm italic font-medium">Tabungan Siswa An Nadzir</p>
        </div>

        <div class="mb-10 text-center print:mb-6">
            <h2 class="text-xl font-bold text-slate-800 mb-2 print:text-lg">Assalamu'alaikum, {{ $student->name }}</h2>
            <p class="text-slate-600 leading-relaxed text-sm">
                Selamat datang di aplikasi TASIA! <br>
                Terima kasih telah bergabung dan memiliki semangat untuk menabung bersama kami. 
                Semoga dengan menabung sejak dini, cita-citamu dapat terwujud dengan baik.
            </p>
        </div>

        <div class="bg-slate-50 rounded-2xl p-6 border border-dashed border-slate-300 mb-8 print:p-4 print:mb-4">
            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-4 text-center">Akses Akun Anda</p>
            
            <div class="space-y-4 print:space-y-2">
                <div class="flex justify-between items-center py-2 border-b border-slate-200 print:py-1">
                    <span class="text-slate-500 text-sm">NIS (Username)</span>
                    <span class="font-mono font-bold text-[#1e3a29]">{{ $student->student_id }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-200 print:py-1">
                    <span class="text-slate-500 text-sm">Email</span>
                    <span class="font-medium text-slate-800">{{ $student->email }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-200 print:py-1">
                    <span class="text-slate-500 text-sm">Kelas</span>
                    <span class="font-medium text-slate-800">{{ $student->classRoom ? $student->classRoom->name : '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-200 print:py-1">
                    <span class="text-slate-500 text-sm">Password</span>
                    <span class="font-mono font-bold text-rose-600">12345678</span>
                </div>
                <div class="flex justify-between items-center py-2 print:py-1">
                    <div class="text-left">
                        <span class="text-slate-500 text-sm block">Keamanan Akun</span>
                        <span class="text-[10px] text-slate-400 italic font-medium">*Silakan segera ganti password setelah pertama kali login</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-100 mb-10 print:mb-4 print:p-2">
            <p class="text-xs text-emerald-700 text-center leading-relaxed">
                <strong>Tips:</strong> Gunakan NIS atau Email untuk masuk ke dalam aplikasi. 
                Simpan data ini dengan baik dan jangan berikan kepada orang lain demi keamanan tabunganmu.
            </p>
        </div>

        <div class="text-center text-xs text-slate-400">
            <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
            <p class="mt-1">Aplikasi Tabungan Siswa An Nadzir - Masa Depan Cerah Dimulai dari Menabung</p>
        </div>
    </div>
    @endforeach

    <!-- Actions -->
    <div class="fixed bottom-8 left-1/2 transform -translate-x-1/2 flex gap-4 print:hidden z-50">
        <button onclick="window.print()" class="px-6 py-3 bg-[#1e3a29] text-white rounded-full font-bold hover:bg-[#2a4d38] transition-all shadow-lg shadow-emerald-900/30 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
            Cetak Semua ({{ count($students) }})
        </button>
        <button onclick="window.close()" class="px-6 py-3 bg-white text-slate-600 rounded-full font-bold hover:bg-slate-50 transition-all shadow-lg border border-slate-200">
            Tutup
        </button>
    </div>

    <style>
        @media print {
            @page { margin: 0; }
            body { margin: 1.6cm; }
            .page-break { page-break-after: always; }
            .page-break:last-child { page-break-after: auto; }
        }
    </style>
</div>
