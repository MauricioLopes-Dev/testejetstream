<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Conectada com ELLAS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Fontes Personalizadas (Orbitron & BioRhyme) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=BioRhyme:wght@300;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-ellas-dark text-white h-screen overflow-hidden">
        
        <div class="flex h-full">
            <!-- Lado Esquerdo (Formulário) -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 sm:px-12 lg:px-24 bg-ellas-card relative z-10 shadow-[20px_0_50px_rgba(0,0,0,0.5)]">
                
                <div class="lg:hidden mb-8 text-center">
                    <a href="/" class="font-orbitron font-bold text-3xl text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">
                       Conectada com ELLAS
                    </a>
                </div>

                <div class="w-full max-w-md mx-auto">
                    {{ $slot }}
                </div>

                <div class="mt-10 text-center text-gray-500 font-biorhyme text-xs">
                    &copy; {{ date('Y') }} Conectada com Ellas.
                </div>
            </div>

            <!-- Lado Direito (Imagem) -->
            <div class="hidden lg:block lg:w-1/2 relative bg-gray-900">
                <!-- ATENÇÃO: Renomeie seu arquivo na pasta public/img para 'login.jpg' (sem acento/espaço) -->
                <img class="absolute inset-0 h-full w-full object-cover" src="{{ asset('img/página de login.jpg') }}" alt="Background" onerror="this.style.display='none'">
                
                <!-- Gradiente apenas na parte inferior (para o texto) -->
                <div class="absolute bottom-0 left-0 right-0 h-1/2 bg-gradient-to-t from-ellas-dark via-ellas-dark/80 to-transparent z-10"></div>

                <!-- Gradiente suave na esquerda (para unir com o formulário) -->
                <div class="absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-ellas-dark to-transparent z-10"></div>
                
                <div class="absolute bottom-20 left-20 right-20 text-white z-20 drop-shadow-lg">
                    <h2 class="font-orbitron text-4xl font-bold mb-4">Juntas transformamos o futuro.</h2>
                    <p class="font-biorhyme text-lg text-gray-200">Conecte-se, inspire-se e construa sua jornada na tecnologia.</p>
                </div>
            </div>
        </div>
    </body>
</html>