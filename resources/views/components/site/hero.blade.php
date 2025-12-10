<section id="inicio" class="relative min-h-screen flex items-center justify-center pt-20 overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('img/inicio.jpg') }}" alt="Fundo" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-gradient-to-b from-ellas-dark/80 via-ellas-dark/60 to-ellas-dark"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 text-center lg:text-left grid lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-8 animate__animated animate__fadeInLeft">
            <img src="{{ asset('img/2.png') }}" alt="Logo Ellas" class="h-24 md:h-32 mx-auto lg:mx-0 drop-shadow-[0_0_10px_rgba(255,255,255,0.3)]">
            
            <h1 class="font-orbitron text-4xl md:text-6xl font-bold leading-tight">
                Empoderando mulheres na <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-pink to-ellas-cyan">tecnologia</span>
            </h1>
            
            <p class="font-biorhyme text-lg md:text-xl text-gray-300 leading-relaxed">
                Descubra um universo onde a força feminina se une à inovação. Junte-se a nós e transforme o futuro através da inclusão e conexão.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                <a href="{{ route('register') }}" class="font-orbitron px-8 py-4 rounded-xl bg-gradient-to-r from-ellas-purple to-ellas-pink text-white font-bold text-lg shadow-[0_0_20px_rgba(165,4,170,0.4)] hover:scale-105 transition-transform hover:shadow-[0_0_30px_rgba(227,20,117,0.6)]">
                    Começar Agora
                </a>
                <a href="{{ route('site.about') }}" class="font-orbitron px-8 py-4 rounded-xl border border-ellas-cyan text-ellas-cyan font-bold text-lg hover:bg-ellas-cyan hover:text-ellas-dark transition-colors">
                    Saiba Mais
                </a>
            </div>
        </div>
        
        <div class="hidden lg:block relative animate__animated animate__fadeInRight">
            <div class="absolute inset-0 bg-gradient-to-r from-ellas-purple to-ellas-cyan blur-[100px] opacity-20 rounded-full"></div>
        </div>
    </div>
</section>