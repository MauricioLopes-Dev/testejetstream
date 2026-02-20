<x-mentora-layout>
    <x-slot name="header">
        <h2 class="font-orbitron font-bold text-xl text-white leading-tight">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Painel</span> da Mentora
        </h2>
    </x-slot>

    <div class="py-12 bg-ellas-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Estatísticas Rápidas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group hover:scale-105 hover:border-ellas-purple transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-graduation-cap text-6xl text-ellas-purple"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Cursos Atribuídos</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ count($cursos) }}</div>
                </div>

                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group hover:scale-105 hover:border-ellas-cyan transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-book-open text-6xl text-ellas-cyan"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Aulas Criadas</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ collect($cursos)->sum(fn($c) => count($c->aulas)) }}</div>
                </div>

                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group hover:scale-105 hover:border-ellas-pink transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-users text-6xl text-ellas-pink"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Alunas Totais</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ collect($cursos)->sum(fn($c) => count($c->inscritos)) }}</div>
                </div>
            </div>

            <!-- Meus Cursos -->
            <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-6 border-b border-ellas-nav">
                    <h3 class="font-orbitron text-lg text-white font-bold flex items-center">
                        <i class="fas fa-graduation-cap text-ellas-purple mr-3"></i>
                        CURSOS ATRIBUÍDOS
                    </h3>
                </div>

                <div class="p-6">
                    @if(count($cursos) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($cursos as $curso)
                                <div class="bg-ellas-dark/50 border border-ellas-nav rounded-xl p-4 hover:border-ellas-purple transition-all">
                                    <h4 class="font-orbitron text-white font-bold mb-2">{{ $curso->nome }}</h4>
                                    
                                    <div class="space-y-1 text-xs text-gray-400 mb-3">
                                        <p><i class="fas fa-calendar text-ellas-cyan mr-1"></i>{{ $curso->data_inicio->format('d/m/Y') }} - {{ $curso->data_fim->format('d/m/Y') }}</p>
                                        <p><i class="fas fa-book text-ellas-pink mr-1"></i>{{ count($curso->aulas) }} aulas</p>
                                        <p><i class="fas fa-users text-ellas-purple mr-1"></i>{{ count($curso->inscritos) }} alunas</p>
                                    </div>

                                    <a href="{{ route('mentora.cursos') }}" class="inline-flex items-center px-3 py-1 bg-ellas-purple/20 text-ellas-purple hover:bg-ellas-purple hover:text-white rounded-lg text-xs font-bold transition-all">
                                        <i class="fas fa-edit mr-1"></i>GERENCIAR
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-graduation-cap text-5xl text-gray-700 mb-4"></i>
                            <p class="text-gray-500 font-biorhyme italic">Nenhum curso atribuído ainda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-mentora-layout>
