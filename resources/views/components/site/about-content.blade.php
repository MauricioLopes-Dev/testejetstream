<section id="sobre" class="py-20 bg-ellas-card/50">
    <div class="max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center gap-12 mb-20">
        <div class="lg:w-1/2 relative group">
            <div class="absolute inset-0 bg-ellas-gradient rounded-3xl blur opacity-30 group-hover:opacity-50 transition duration-500 transform rotate-3"></div>
            
            <img src="{{ asset('img/galeria/sobre-1.jpg') }}" 
                 alt="Nossa História Principal" 
                 class="relative rounded-3xl shadow-2xl border border-white/10 w-full object-cover h-[400px] transform transition duration-500 group-hover:scale-[1.02]">
        </div>
        
        <div class="lg:w-1/2 space-y-6">
            <h5 class="font-orbitron text-ellas-pink tracking-widest uppercase text-sm">Sobre Nós</h5>
            <h2 class="font-orbitron text-4xl font-bold text-white">A Nossa História</h2>
            <p class="font-biorhyme text-gray-300 leading-relaxed text-justify">
                Idealizada por Rosana Mendes e fundada em 2025, o projeto <strong>'Conectada com Ellas'</strong> nasceu da paixão por promover a inclusão. Oferecemos oficinas interativas, eventos inspiradores e uma rede de apoio colaborativa. Acreditamos que, juntas, podemos superar barreiras e conectar mulheres de diferentes perfis para transformar o futuro da tecnologia.
            </p>
            
            <div class="pt-4">
                <a href="{{ route('site.services') }}" class="inline-flex items-center px-6 py-3 bg-ellas-pink text-white font-bold rounded-lg hover:bg-pink-600 transition shadow-lg shadow-pink-500/30">
                    Conheça Nossos Projetos
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6">
        <h3 class="font-orbitron text-2xl text-white mb-8 border-l-4 border-ellas-pink pl-4">
            Nossos Momentos
        </h3>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
            
            @php
                // Lista das fotos sequenciais (ajuste se você nomeou diferente de sobre-2, sobre-3...)
                $fotos = [
                    'sobre-2.jpg', 
                    'sobre-3.jpg', 
                    'sobre-4.jpg', 
                    'sobre-5.jpg', 
                    'sobre-6.jpg', 
                    'sobre-7.jpg'
                ];
            @endphp

            @foreach($fotos as $foto)
                <div class="relative overflow-hidden rounded-xl group h-48 sm:h-64 cursor-pointer">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent transition z-10"></div>
                    <img src="{{ asset('img/galeria/' . $foto) }}" 
                         alt="Momento Projeto Ellas" 
                         class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-in-out">
                </div>
            @endforeach
            
        </div>
    </div>
</section>