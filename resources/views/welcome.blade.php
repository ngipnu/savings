<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TASIA - Tabungan Siswa An Nadzir</title>
    <link rel="icon" type="image/png" href="{{ asset('logo_round.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: '#10b981', // Emerald 500
                        secondary: '#f59e0b', // Amber 500
                        dark: '#0f172a',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-lime-50 min-h-screen relative overflow-x-hidden text-slate-800">

    <!-- Decorative Shapes -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-lime-100 rounded-full blur-3xl opacity-20 -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-amber-200 rounded-full blur-3xl opacity-20 translate-y-1/2 -translate-x-1/2"></div>

    <!-- Navbar -->
    <nav class="relative z-10 container mx-auto px-6 py-6 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-#1e3a29 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">T</div>
            <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-#1e3a29 to-#1e3a29">TabunganSiswa</span>
        </div>
        <div class="hidden md:flex gap-8 font-medium text-slate-600">
            <a href="#features" class="hover:text-#1e3a29 transition">Fitur</a>
            <a href="#about" class="hover:text-#1e3a29 transition">Tentang</a>
            <a href="#contact" class="hover:text-#1e3a29 transition">Kontak</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="relative z-10 container mx-auto px-6 pt-10 pb-20 flex flex-col lg:flex-row items-center gap-16">
        <!-- Text Content -->
        <div class="flex-1 text-center lg:text-left">
            <div class="inline-block px-4 py-1.5 bg-white border border-lime-50 rounded-full text-#1e3a29 font-semibold text-sm mb-6 shadow-sm">
                👋 Selamat Datang di Platform Tabungan Sekolah
            </div>
            <h1 class="text-5xl lg:text-7xl font-bold leading-tight mb-6 text-slate-900">
                Kelola Tabungan <br>
                <span class="text-#1e3a29">Lebih Mudah</span> & Aman
            </h1>
            <p class="text-lg text-slate-600 mb-10 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                TASIA (Tabungan Siswa An Nadzir) - Aplikasi pencatatan tabungan siswa yang transparan, modern, dan mudah diakses. Pantau saldo dan riwayat transaksi kapan saja, di mana saja.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                <a href="/login" class="group relative px-8 py-4 bg-#1e3a29 text-white font-semibold rounded-2xl shadow-lime-100 shadow-xl hover:shadow-2xl hover:bg-#2a4d38 transition-all duration-300 flex items-center justify-center gap-2 overflow-hidden w-full sm:w-auto">
                    <span class="relative z-10">Login Akun</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 relative z-10 group-hover:translate-x-1 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>
                </a>
            </div>
            
            <div class="mt-12 flex items-center justify-center lg:justify-start gap-6 text-sm text-slate-500">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-lime-400"></div>
                    Real-time Data
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                    Aman & Terpercaya
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                    Akses Mobile
                </div>
            </div>
        </div>

        <!-- Visual/Illustration -->
        <div class="flex-1 relative w-full max-w-lg lg:max-w-none">
            <div class="relative w-full aspect-square max-w-md mx-auto animate-float">
                <!-- Abstract Cards UI -->
                <div class="absolute inset-0 bg-gradient-to-tr from-lime-400 to-lime-400 rounded-[3rem] rotate-6 opacity-20 blur-lg"></div>
                <div class="glass-card absolute inset-4 rounded-[2.5rem] p-8 flex flex-col justify-between">
                    <!-- Fake UI Elements -->
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <div class="text-xs text-slate-400 font-medium uppercase tracking-wider">Total Tabungan</div>
                            <div class="text-3xl font-bold text-slate-800">Rp 2.500.000</div>
                        </div>
                        <div class="w-12 h-12 bg-lime-50 rounded-full flex items-center justify-center text-#1e3a29">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.314.164-.623.546-1.003zm3.072 6.502c-.394.314-.546.681-.546 1.004 0 .324.164.633.546 1.004.227.18.497.311.786.394v-2.795a2.252 2.252 0 01-.786.393zm1.603-4.527c.501.378.892.68 1.171 1.026.279.346.419.743.419 1.192 0 .61-.242 1.127-.726 1.55-.484.423-1.126.697-1.927.822v1.393h-1.5v-1.316a5.54 5.54 0 01-1.25-.19c-.439-.12-.865-.333-1.28-.638l.68-1.272c.307.27.64.475.999.614.359.139.697.209 1.015.209.439 0 .805-.102 1.1-.304.294-.202.441-.497.441-.883 0-.398-.168-.748-.504-1.05-.336-.303-.767-.547-1.291-.734-.524-.186-1.007-.404-1.449-.652-.442-.249-.785-.572-1.029-.97-.245-.397-.367-.883-.367-1.457 0-.61.242-1.127.726-1.55.485-.423 1.127-.697 1.927-.822V4.5h1.5v1.316c.404.05.815.14 1.233.27.418.13.843.332 1.276.603l-.683 1.275c-.389-.258-.78-.445-1.173-.562-.393-.117-.751-.176-1.074-.176-.43 0-.796.102-1.099.305-.303.203-.454.498-.454.883 0 .389.168.73.504 1.027.336.297.777.537 1.32.72.544.182 1.042.404 1.494.666.452.261.799.59 1.04.987.241.397.362.884.362 1.46z" />
                            </svg>
                        </div>
                    </div>
                
                    <!-- List -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="text-sm">
                                    <div class="font-bold text-slate-700">Setor Tunai</div>
                                    <div class="text-xs text-slate-500">Senin, 12 Feb</div>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-#1e3a29">+ Rp 50.000</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                    </svg>
                                </div>
                                <div class="text-sm">
                                    <div class="font-bold text-slate-700">Tabungan Wajib</div>
                                    <div class="text-xs text-slate-500">Kamis, 08 Feb</div>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-#1e3a29">+ Rp 20.000</span>
                        </div>
                         <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl opacity-60">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                        <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="text-sm">
                                    <div class="font-bold text-slate-700">Penarikan</div>
                                    <div class="text-xs text-slate-500">Jumat, 02 Feb</div>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-slate-500">- Rp 15.000</span>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="mt-8">
                        <div class="h-10 w-full bg-slate-900 rounded-xl"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Features -->
    <section id="features" class="bg-white py-20">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-16 text-slate-800">Kenapa Memilih Kami?</h2>
            
            <div class="grid md:grid-cols-3 gap-10">
                <div class="p-8 rounded-3xl bg-slate-50 hover:bg-lime-50 transition duration-300 border border-slate-100 hover:border-lime-50">
                    <div class="w-14 h-14 bg-lime-50 rounded-2xl flex items-center justify-center text-#1e3a29 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-slate-800">Akses Mudah</h3>
                    <p class="text-slate-600 leading-relaxed">Siswa dapat mengecek saldo dan riwayat transaksi langsung dari HP masing-masing melalui panel siswa.</p>
                </div>

                <div class="p-8 rounded-3xl bg-slate-50 hover:bg-lime-50 transition duration-300 border border-slate-100 hover:border-lime-50">
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 5.523-4.477 10-10 10S1 17.523 1 12 5.477 2 11 2s10 4.477 10 10z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-slate-800">Data Transparan</h3>
                    <p class="text-slate-600 leading-relaxed">Setiap transaksi tercatat dengan detail, memastikan transparansi antara sekolah, siswa, dan orang tua.</p>
                </div>

                <div class="p-8 rounded-3xl bg-slate-50 hover:bg-lime-50 transition duration-300 border border-slate-100 hover:border-lime-50">
                    <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5m.75-9l3-3 2.148 2.148A12.061 12.061 0 0116.5 7.605" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-slate-800">Manajemen Efisien</h3>
                    <p class="text-slate-600 leading-relaxed">Panel admin yang powerful memudahkan petugas sekolah mengelola ratusan data siswa dan transaksi.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-900 text-white py-8 border-t border-slate-800">
        <div class="container mx-auto px-6 text-center text-slate-400 text-sm">
            &copy; 2026 TabunganSiswa. All rights reserved.
        </div>
    </footer>

</body>
</html>
