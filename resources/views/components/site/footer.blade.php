<footer class="bg-ellas-card border-t border-ellas-nav pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-8">
        <div class="text-center md:text-left">
            <img src="{{ asset('img/2.png') }}" alt="Logo" class="h-16 mx-auto md:mx-0 mb-4">
            <p class="font-biorhyme text-gray-400 text-sm max-w-xs">Juntas, transformamos o futuro da tecnologia!</p>
        </div>
        
        <div class="text-center md:text-right font-orbitron text-sm">
            <ul class="space-y-2">
                <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors">Início</a></li>
                <li><a href="{{ route('site.about') }}" class="text-gray-400 hover:text-white transition-colors">Sobre</a></li>
                <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition-colors">Login</a></li>
            </ul>
        </div>
    </div>
    <div class="text-center mt-12 pt-8 border-t border-ellas-nav/30">
        <p class="font-biorhyme text-gray-500 text-sm">© {{ date('Y') }} | Conectada com Ellas</p>
    </div>
</footer>