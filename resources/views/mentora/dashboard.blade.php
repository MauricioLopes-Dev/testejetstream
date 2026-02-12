<x-app-layout>
    <x-slot name="header">
        <h2 class="font-orbitron font-bold text-xl text-white leading-tight">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Painel</span> da Mentora
        </h2>
    </x-slot>

    <div class="py-12 bg-ellas-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl p-8 relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-ellas-purple/10 rounded-full blur-3xl"></div>
                
                <div class="relative z-10">
                    <h3 class="font-orbitron text-3xl font-bold text-white mb-2">Olá, {{ Auth::guard('mentora')->user()->nome }}!</h3>
                    <p class="font-biorhyme text-gray-400 mb-10">Bem-vinda ao seu ecossistema de mentoria. Transforme vidas através do conhecimento.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="p-6 bg-ellas-dark/50 border border-ellas-nav rounded-xl hover:border-ellas-pink/50 transition-all group cursor-pointer">
                            <div class="w-12 h-12 bg-ellas-pink/20 rounded-lg flex items-center justify-center text-ellas-pink mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-graduation-cap text-xl"></i>
                            </div>
                            <h4 class="font-orbitron text-white font-bold mb-2">Meus Cursos</h4>
                            <p class="text-xs text-gray-400 font-biorhyme mb-4">Crie trilhas de aprendizado e compartilhe sua expertise.</p>
                            <span class="text-ellas-pink text-xs font-bold flex items-center gap-2">GERENCIAR <i class="fas fa-arrow-right"></i></span>
                        </div>

                        <div class="p-6 bg-ellas-dark/50 border border-ellas-nav rounded-xl hover:border-ellas-cyan/50 transition-all group cursor-pointer">
                            <div class="w-12 h-12 bg-ellas-cyan/20 rounded-lg flex items-center justify-center text-ellas-cyan mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-calendar-star text-xl"></i>
                            </div>
                            <h4 class="font-orbitron text-white font-bold mb-2">Eventos ao Vivo</h4>
                            <p class="text-xs text-gray-400 font-biorhyme mb-4">Organize workshops e mentorias coletivas em tempo real.</p>
                            <span class="text-ellas-cyan text-xs font-bold flex items-center gap-2">ORGANIZAR <i class="fas fa-arrow-right"></i></span>
                        </div>

                        <div class="p-6 bg-ellas-dark/50 border border-ellas-nav rounded-xl hover:border-ellas-purple/50 transition-all group cursor-pointer">
                            <div class="w-12 h-12 bg-ellas-purple/20 rounded-lg flex items-center justify-center text-ellas-purple mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <h4 class="font-orbitron text-white font-bold mb-2">Minha Agenda</h4>
                            <p class="text-xs text-gray-400 font-biorhyme mb-4">Visualize seus horários e conexões agendadas com as alunas.</p>
                            <span class="text-ellas-purple text-xs font-bold flex items-center gap-2">VISUALIZAR <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
