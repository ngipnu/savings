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
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <style>
         [x-cloak] { display: none !important; }
         
         /* Choices.js Custom Styling */
         .choices__inner {
             background-color: white;
             border: 1px solid #e2e8f0; /* slate-200 */
             border-radius: 0.5rem; /* rounded-lg */
             padding: 0.5rem 1rem;
             min-height: 46px; 
             font-size: 0.875rem; /* text-sm */
         }
         .choices:focus-within .choices__inner {
             border-color: transparent;
             box-shadow: 0 0 0 2px #10b981; /* primary / emerald-500 */
         }
         .choices__list--dropdown {
             border: 1px solid #e2e8f0;
             border-radius: 0.5rem;
             box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
             margin-top: 4px;
         }
         .choices__list--dropdown .choices__item--selectable.is-highlighted {
             background-color: #ecfdf5; /* emerald-50 */
             color: #064e3b;
         }
    </style>
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100 min-h-screen text-slate-800 font-sans antialiased">
    {{ $slot }}
    @livewireScripts
</body>
</html>
