<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'TASIA - Tabungan Siswa An Nadzir' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('logo_round.png') }}">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (CDN for Speed) -->
    <script src="https://cdn.tailwindcss.com"></script>
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
         [x-cloak] { display: none !important; }
    </style>
    @livewireStyles
</head>
<body class="bg-gray-50 text-slate-800 font-sans antialiased">
    {{ $slot }}
    @livewireScripts
</body>
</html>
