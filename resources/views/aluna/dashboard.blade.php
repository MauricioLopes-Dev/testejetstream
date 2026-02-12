<x-app-layout>
    <x-slot name="header">
        <h2 class="font-orbitron font-bold text-xl text-white leading-tight">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-cyan to-ellas-purple">Área</span> da Aluna
        </h2>
    </x-slot>

    <div class="py-12 bg-ellas-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl p-8">
                <div class="flex flex-col md:flex-row items-center justify-between mb-10 gap-6">
                    <div>
                        <h3 class="font-orbitron text-3xl font-bold text-white mb-2 text-center md:text-left">Bem-vinda, {{ Auth::user()->name }}!</h3>
                        <p class="font-biorhyme text-gray-400 text-center md:text-left">Pronta para dar o próximo passo na sua carreira tecnológica?</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="text-center px-6 py-3 bg-ellas-dark/50 rounded-xl border border-ellas-nav">
                            <div class="text-ellas-cyan font-bold text-xl">0</div>
                            <div class="text-[10px] text-gray-500 uppercase font-orbitron">Cursos</div>
                        </div>
                        <div class="text-center px-6 py-3 bg-ellas-dark/50 rounded-xl border border-ellas-nav">
                            <div class="text-ellas-pink font-bold text-xl">0</div>
                            <div class="text-[10px] text-gray-500 uppercase font-orbitron">Eventos</div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-ellas-dark/40 border border-ellas-nav rounded-2xl p-6 hover:border-ellas-cyan/30 transition-all group">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 rounded-full bg-ellas-cyan/20 flex items-center justify-center text-ellas-cyan">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h4 class="font-orbitron text-white font-bold uppercase tracking-wider">Minhas Inscrições</h4>
                        </div>
                        <div class="text-center py-10 bg-ellas-dark/20 rounded-xl border border-dashed border-ellas-nav">
                            <p class="text-gray-500 font-biorhyme italic text-sm mb-6">Você ainda não está inscrita em nenhuma jornada.</p>
                            <a href="/" class="px-6 py-3 bg-gradient-to-r from-ellas-cyan to-ellas-purple rounded-lg font-orbitron font-bold text-xs text-white hover:scale-105 transition-all inline-block">
                                EXPLORAR CONTEÚDOS
                            </a>
                        </div>
                    </div>

                    <div class="bg-ellas-dark/40 border border-ellas-nav rounded-2xl p-6 hover:border-ellas-pink/30 transition-all group">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 rounded-full bg-ellas-pink/20 flex items-center justify-center text-ellas-pink">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <h4 class="font-orbitron text-white font-bold uppercase tracking-wider">Próximas Aulas</h4>
                        </div>
                        <div class="text-center py-10 bg-ellas-dark/20 rounded-xl border border-dashed border-ellas-nav">
                            <p class="text-gray-500 font-biorhyme italic text-sm">Sua agenda está livre. Que tal marcar uma mentoria?</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
