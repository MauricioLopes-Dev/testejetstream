<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-slate-800 dark:bg-ellas-dark dark:text-white h-screen overflow-hidden transition-colors duration-300">
        <div class="flex h-full">
            <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-12 lg:px-24 bg-white dark:bg-ellas-card relative z-10 shadow-[20px_0_50px_rgba(0,0,0,0.1)] dark:shadow-[20px_0_50px_rgba(0,0,0,0.5)] transition-colors duration-300">
                
                <div class="lg:hidden mb-8 text-center">
                    <a href="/" class="font-orbitron font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">
                       Projeto ELLAS
                    </a>
                </div>

                <div class="w-full max-w-md mx-auto">
                    {{ $slot }}
                </div>

                <div class="mt-10 text-center text-gray-400 dark:text-gray-500 font-biorhyme text-xs">
                    &copy; {{ date('Y') }} Conectada com Ellas.
                </div>
            </div>

            <div class="hidden lg:block lg:w-1/2 relative">
                <img class="absolute inset-0 h-full w-full object-cover" src="{{ asset('img/Página de login.jpg') }}" alt="Background">
                <div class="absolute inset-0 bg-gradient-to-l from-white/10 via-transparent to-transparent dark:from-ellas-dark/80 dark:via-ellas-purple/20"></div>
                
                <div class="absolute bottom-20 left-20 right-20 text-white z-20 drop-shadow-lg">
                    <h2 class="font-orbitron text-4xl font-bold mb-4">Juntas transformamos o futuro.</h2>
                    <p class="font-biorhyme text-lg text-gray-100">Conecte-se, inspire-se e construa sua jornada na tecnologia.</p>
                </div>
            </div>
        </div>
    </body>
</html>