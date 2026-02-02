<div class="max-w-xl mx-auto my-10 bg-white p-8 rounded-xl shadow-lg border border-slate-200 print:shadow-none print:border-none print:m-0 print:max-w-none">
    <div class="text-center mb-8 border-b border-slate-200 pb-6">
        <img src="{{ asset('logo_round.png') }}" alt="Logo" class="w-16 h-16 mx-auto mb-3 object-cover rounded-lg">
        <h1 class="text-2xl font-bold text-[#1e3a29]">TASIA</h1>
        <p class="text-slate-500 text-sm">Tabungan Siswa An Nadzir</p>
        <p class="text-slate-500 text-xs mt-1">Bukti Transaksi</p>
    </div>

    <div class="space-y-4 mb-8">
        <div class="flex justify-between items-center py-2 border-b border-dashed border-slate-200">
            <span class="text-slate-500 text-sm">No. Transaksi</span>
            <span class="font-mono font-bold text-slate-800">#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="flex justify-between items-center py-2 border-b border-dashed border-slate-200">
            <span class="text-slate-500 text-sm">Tanggal</span>
            <span class="font-medium text-slate-800">{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</span>
        </div>
        <div class="flex justify-between items-center py-2 border-b border-dashed border-slate-200">
            <span class="text-slate-500 text-sm">Siswa</span>
            <div class="text-right">
                <div class="font-bold text-slate-800">{{ $transaction->user->name }}</div>
                <div class="text-xs text-slate-500">NIS: {{ $transaction->user->student_id }}</div>
            </div>
        </div>
         <div class="flex justify-between items-center py-2 border-b border-dashed border-slate-200">
            <span class="text-slate-500 text-sm">Tipe Tabungan</span>
            <span class="font-medium text-slate-800">{{ $transaction->savingType->name }}</span>
        </div>
        <div class="flex justify-between items-center py-2 border-b border-dashed border-slate-200">
            <span class="text-slate-500 text-sm">Jenis Transaksi</span>
            <span class="font-bold {{ $transaction->type === 'deposit' ? 'text-emerald-600' : 'text-rose-600' }} uppercase text-sm">
                {{ $transaction->type === 'deposit' ? 'Setoran' : 'Penarikan' }}
            </span>
        </div>
        <div class="flex justify-between items-center py-4 border-b-2 border-slate-800">
            <span class="text-slate-800 font-bold">Total</span>
            <span class="font-bold text-xl text-[#1e3a29]">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between items-center py-2">
            <span class="text-slate-500 text-sm">Status</span>
            <span class="px-2 py-1 rounded text-xs font-bold uppercase
                {{ $transaction->status === 'approved' ? 'bg-blue-100 text-blue-700' : 
                   ($transaction->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                {{ $transaction->status }}
            </span>
        </div>
    </div>

    <div class="flex justify-between mt-12 pt-8 text-center text-xs text-slate-500">
        <div class="w-1/3">
            <p class="mb-16">Penyetor/Penarik</p>
            <p class="font-medium text-slate-800">{{ $transaction->user->name }}</p>
        </div>
        <div class="w-1/3">
            <p class="mb-16">Petugas</p>
            <p class="font-medium text-slate-800">Admin/Operator</p>
        </div>
    </div>

    <!-- Print Button (Hidden when printing) -->
    <div class="mt-8 text-center print:hidden space-x-4">
        <button onclick="window.print()" class="px-6 py-2 bg-[#1e3a29] text-white rounded-lg font-bold hover:bg-[#2a4d38] transition-colors shadow-lg">
            Cetak Bukti
        </button>
        <button onclick="window.close()" class="px-6 py-2 bg-slate-100 text-slate-600 rounded-lg font-bold hover:bg-slate-200 transition-colors">
            Tutup
        </button>
    </div>
</div>
