<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Conectada com ELLAS') }} - Mentora</title>
        <link rel="icon" type="image/png" href="{{ asset('img/ellas3.png') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-slate-800 dark:bg-ellas-dark dark:text-white transition-colors duration-300 selection:bg-ellas-pink selection:text-white">
        <x-banner />

        <div class="min-h-screen">
            <x-mentora-nav />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-ellas-card shadow border-b border-gray-100 dark:border-ellas-nav">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')
        @livewireScripts
    </body>
</html>
