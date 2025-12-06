<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="relative overflow-hidden bg-ellas-card rounded-[50px] p-10 mb-12 shadow-2xl border-t border-r border-white/10 group">
                <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-ellas-purple/20 to-transparent pointer-events-none group-hover:from-ellas-pink/20 transition-all duration-1000"></div>

                <div class="relative z-10">
                    <h1 class="font-orbitron text-4xl mb-4 text-white">
                        Olá, {{ Auth::user()->name }}! 👋
                    </h1>
                    <p class="font-biorhyme text-xl text-gray-300 max-w-2xl">
                        Bem-vinda ao seu painel. O que você gostaria de explorar hoje?
                    </p>
                    <div class="w-[200px] h-[3px] bg-ellas-gradient mt-6 mb-2 rounded-full"></div>
                </div>
            </div>


            <div class="mb-12 bg-ellas-dark/50 border border-ellas-nav rounded-2xl p-6 flex flex-col md:flex-row items-center gap-6 relative overflow-hidden">
    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-ellas-cyan to-ellas-purple"></div>
    
    <div class="relative w-20 h-20 shrink-0">
        <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
            <path class="text-ellas-nav" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
            <path class="text-ellas-cyan drop-shadow-[0_0_5px_rgba(4,203,239,0.8)]" stroke-dasharray="75, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
        </svg>
        <div class="absolute inset-0 flex items-center justify-center font-orbitron text-sm font-bold text-white">
            75%
        </div>
    </div>

    <div class="flex-1 text-center md:text-left">
        <h3 class="font-orbitron text-lg text-white mb-1">Seu perfil está quase completo!</h3>
        <p class="font-biorhyme text-sm text-gray-400">Adicione suas redes sociais e biografia para ganhar mais visibilidade na comunidade Ellas.</p>
    </div>

    <a href="{{ route('completar-perfil') }}" class="whitespace-nowrap px-5 py-2.5 bg-ellas-card hover:bg-ellas-nav border border-ellas-cyan/30 text-ellas-cyan font-orbitron text-sm rounded-lg transition-all hover:scale-105">
        Completar Agora
    </a>
</div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <a href="{{ route('completar-perfil') }}" class="group block bg-ellas-card p-8 rounded-[20px] border-t-4 border-transparent hover:-translate-y-2 transition-all duration-300 shadow-lg hover:shadow-[0_20px_40px_rgba(165,4,170,0.2)] relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-ellas-gradient"></div>
                    <div class="text-4xl mb-6 text-ellas-purple group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <h3 class="font-orbitron text-2xl text-white mb-2 group-hover:text-ellas-purple transition-colors">Meu Perfil</h3>
                    <p class="font-biorhyme text-gray-400 text-sm">Atualize seus dados e currículo.</p>
                </a>

                <a href="{{ route('blog.index') }}" class="group block bg-ellas-card p-8 rounded-[20px] border-t-4 border-transparent hover:-translate-y-2 transition-all duration-300 shadow-lg hover:shadow-[0_20px_40px_rgba(227,20,117,0.2)] relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-ellas-gradient"></div>
                    <div class="text-4xl mb-6 text-ellas-pink group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    <h3 class="font-orbitron text-2xl text-white mb-2 group-hover:text-ellas-pink transition-colors">Histórias</h3>
                    <p class="font-biorhyme text-gray-400 text-sm">Inspire-se com trajetórias incríveis.</p>
                </a>

                <a href="{{ route('eventos.index') }}" class="group block bg-ellas-card p-8 rounded-[20px] border-t-4 border-transparent hover:-translate-y-2 transition-all duration-300 shadow-lg hover:shadow-[0_20px_40px_rgba(4,203,239,0.2)] relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-ellas-gradient"></div>
                    <div class="text-4xl mb-6 text-ellas-cyan group-hover:scale-110 transition-transform duration-300">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <h3 class="font-orbitron text-2xl text-white mb-2 group-hover:text-ellas-cyan transition-colors">Eventos</h3>
                    <p class="font-biorhyme text-gray-400 text-sm">Inscreva-se em workshops e palestras.</p>
                </a>

                <a href="{{ route('candidaturas.index') }}" class="group block bg-ellas-card p-8 rounded-[20px] border-t-4 border-transparent hover:-translate-y-2 transition-all duration-300 shadow-lg hover:shadow-[0_20px_40px_rgba(255,255,255,0.1)] relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-ellas-gradient"></div>
                    <div class="text-4xl mb-6 text-gray-300 group-hover:text-white group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                    </div>
                    <h3 class="font-orbitron text-2xl text-white mb-2 group-hover:text-white transition-colors">Inscrições</h3>
                    <p class="font-biorhyme text-gray-400 text-sm">Acompanhe o status das suas vagas.</p>
                </a>

                @if(Auth::user()->role === 'mentora' || Auth::user()->role === 'admin')
                    <a href="{{ route('solicitacoes.index') }}" class="group block bg-ellas-card p-8 rounded-[20px] border-t-4 border-transparent hover:-translate-y-2 transition-all duration-300 shadow-lg hover:shadow-[0_20px_40px_rgba(227,20,117,0.3)] relative overflow-hidden col-span-1 md:col-span-2 lg:col-span-1 border-r border-ellas-pink/30">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-ellas-pink to-ellas-purple"></div>
                        <div class="text-4xl mb-6 text-ellas-pink group-hover:scale-110 transition-transform duration-300">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <h3 class="font-orbitron text-2xl text-white mb-2 group-hover:text-ellas-pink transition-colors">Gestão</h3>
                        <p class="font-biorhyme text-gray-400 text-sm">Área exclusiva para mentoras e admins.</p>
                    </a>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>