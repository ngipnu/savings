<div class="max-w-4xl mx-auto my-10 bg-white p-8 rounded-xl shadow-lg border border-slate-200 print:shadow-none print:border-none print:m-0 print:max-w-none">
    <div class="text-center mb-8 border-b border-slate-200 pb-6">
        <img src="{{ asset('logo_round.png') }}" alt="Logo" class="w-20 h-20 mx-auto mb-3 object-cover rounded-lg">
        <h1 class="text-2xl font-bold text-[#1e3a29]">TASIA</h1>
        <p class="text-slate-500 text-sm">Tabungan Siswa An Nadzir</p>
        <h2 class="text-xl font-bold mt-4 text-slate-800">REKAPAN TABUNGAN KELAS {{ $classRoom->name }}</h2>
        <p class="text-xs text-slate-500">Tanggal Cetak: {{ now()->format('d F Y') }}</p>
    </div>

    <div class="overflow-x-auto mb-8">
        <table class="w-full border-collapse border border-slate-300">
            <thead>
                <tr class="bg-slate-100 text-slate-700 text-sm">
                    <th class="border border-slate-300 px-4 py-2 w-12">No</th>
                    <th class="border border-slate-300 px-4 py-2 text-left">Nama Siswa</th>
                    <th class="border border-slate-300 px-4 py-2 w-24">NIS</th>
                    <th class="border border-slate-300 px-4 py-2 text-right">Total Setoran</th>
                    <th class="border border-slate-300 px-4 py-2 text-right">Total Penarikan</th>
                    <th class="border border-slate-300 px-4 py-2 text-right font-bold">Saldo Akhir</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $grandTotalDeposit = 0;
                    $grandTotalWithdrawal = 0;
                    $grandTotalBalance = 0;
                @endphp
                @foreach($students as $index => $student)
                @php
                    $balance = $student->total_deposit - $student->total_withdrawal;
                    $grandTotalDeposit += $student->total_deposit;
                    $grandTotalWithdrawal += $student->total_withdrawal;
                    $grandTotalBalance += $balance;
                @endphp
                <tr class="text-sm">
                    <td class="border border-slate-300 px-4 py-2 text-center">{{ $index + 1 }}</td>
                    <td class="border border-slate-300 px-4 py-2">{{ $student->name }}</td>
                    <td class="border border-slate-300 px-4 py-2 text-center">{{ $student->student_id }}</td>
                    <td class="border border-slate-300 px-4 py-2 text-right text-emerald-600">
                        {{ number_format($student->total_deposit, 0, ',', '.') }}
                    </td>
                    <td class="border border-slate-300 px-4 py-2 text-right text-rose-600">
                        {{ number_format($student->total_withdrawal, 0, ',', '.') }}
                    </td>
                    <td class="border border-slate-300 px-4 py-2 text-right font-bold text-slate-800">
                        {{ number_format($balance, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-slate-50 font-bold text-sm">
                    <td colspan="3" class="border border-slate-300 px-4 py-3 text-center">TOTAL KELAS</td>
                    <td class="border border-slate-300 px-4 py-3 text-right text-emerald-700">
                        {{ number_format($grandTotalDeposit, 0, ',', '.') }}
                    </td>
                     <td class="border border-slate-300 px-4 py-3 text-right text-rose-700">
                        {{ number_format($grandTotalWithdrawal, 0, ',', '.') }}
                    </td>
                    <td class="border border-slate-300 px-4 py-3 text-right text-[#1e3a29]">
                        {{ number_format($grandTotalBalance, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="flex justify-between mt-12 pt-8 text-center text-xs text-slate-500 break-inside-avoid">
        <div class="w-1/3">
            <p class="mb-16">Mengetahui,<br>Kepala Sekolah</p>
            <p class="font-medium text-slate-800">( ...................................... )</p>
        </div>
        <div class="w-1/3">
            <p class="mb-16">Bogor, {{ now()->format('d F Y') }}<br>Wali Kelas</p>
            <p class="font-medium text-slate-800">( ...................................... )</p>
        </div>
    </div>

    <!-- Print Button (Hidden when printing) -->
    <div class="mt-8 text-center print:hidden space-x-4">
        <button onclick="window.print()" class="px-6 py-2 bg-[#1e3a29] text-white rounded-lg font-bold hover:bg-[#2a4d38] transition-colors shadow-lg">
            Cetak Rekapan
        </button>
        <button onclick="window.close()" class="px-6 py-2 bg-slate-100 text-slate-600 rounded-lg font-bold hover:bg-slate-200 transition-colors">
            Tutup
        </button>
    </div>
</div>
