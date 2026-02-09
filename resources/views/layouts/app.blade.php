<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Conectada com ELLAS') }}</title>
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
            @livewire('navigation-menu')

            <main class="pt-6">
                {{ $slot }}
            </main>
        </div>

        @stack('modals')
        @livewireScripts


        <script>
    (function() {
        // Pega o nome do app definido no seu .env ou o padrão
        let titleText = "{{ config('app.name', 'Conectada com ELLAS') }}";
        titleText += " • "; // Adiciona um separador para o loop
        
        setInterval(function() {
            // Move a primeira letra para o final da string
            titleText = titleText.substring(1) + titleText.substring(0, 1);
            document.title = titleText;
        }, 200); // Velocidade (200ms). Quanto menor, mais rápido.
    })();
</script>
    </body>
</html>