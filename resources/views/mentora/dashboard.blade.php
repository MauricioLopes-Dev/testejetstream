<x-mentora-layout>
    <x-slot name="header">
        <h2 class="font-orbitron font-bold text-xl text-white leading-tight">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Painel</span> da Mentora
        </h2>
    </x-slot>

    <div class="py-12 bg-ellas-dark min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Estatísticas Rápidas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group hover:scale-105 hover:border-ellas-purple transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-graduation-cap text-6xl text-ellas-purple"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Cursos</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ $totalCursos }}</div>
                </div>

                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group hover:scale-105 hover:border-ellas-cyan transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-book-open text-6xl text-ellas-cyan"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Aulas</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ collect($cursos)->sum(fn($c) => count($c->aulas)) }}</div>
                </div>

                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group hover:scale-105 hover:border-ellas-pink transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-users text-6xl text-ellas-pink"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Alunas</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ collect($cursos)->sum(fn($c) => count($c->inscritos)) }}</div>
                </div>

                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden group hover:scale-105 hover:border-ellas-cyan transition-all">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-comments text-6xl text-ellas-cyan"></i>
                    </div>
                    <div class="text-sm font-orbitron text-gray-400 uppercase tracking-wider">Dúvidas</div>
                    <div class="text-4xl font-bold text-white mt-2">{{ \App\Models\MensagemChat::where('mentora_id', Auth::guard('mentora')->id())->where('lida', false)->count() }}</div>
                </div>
            </div>

            <!-- Ações Rápidas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-8 shadow-2xl">
                    <h3 class="font-orbitron text-lg text-white font-bold mb-6 flex items-center">
                        <i class="fas fa-tasks text-ellas-purple mr-3"></i>
                        GERENCIAMENTO
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('mentora.cursos') }}" class="p-4 bg-ellas-dark/50 border border-ellas-nav rounded-xl hover:border-ellas-purple transition-all group">
                            <div class="text-ellas-purple font-bold text-sm group-hover:scale-105 transition-all">Gerenciar Cursos</div>
                            <p class="text-[10px] text-gray-500 mt-1">Aulas, Materiais e Meet</p>
                        </a>
                        <a href="{{ route('mentora.alunas') }}" class="p-4 bg-ellas-dark/50 border border-ellas-nav rounded-xl hover:border-ellas-cyan transition-all group">
                            <div class="text-ellas-cyan font-bold text-sm group-hover:scale-105 transition-all">Minhas Alunas</div>
                            <p class="text-[10px] text-gray-500 mt-1">Presença e Desempenho</p>
                        </a>
                    </div>
                </div>

                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-8 shadow-2xl">
                    <h3 class="font-orbitron text-lg text-white font-bold mb-6 flex items-center">
                        <i class="fas fa-envelope text-ellas-pink mr-3"></i>
                        COMUNICAÇÃO
                    </h3>
                    <div class="space-y-4">
                        @php
                            $ultimasMensagens = \App\Models\MensagemChat::where('mentora_id', Auth::guard('mentora')->id())
                                ->with('user')
                                ->latest()
                                ->take(3)
                                ->get();
                        @endphp
                        @forelse($ultimasMensagens as $msg)
                            <a href="{{ route('mentora.chat.duvidas', ['alunaId' => $msg->user_id]) }}" class="flex items-center p-3 bg-ellas-dark/30 rounded-lg border border-ellas-nav hover:bg-ellas-pink/10 transition-all">
                                <img src="{{ $msg->user->profile_photo_url }}" class="w-8 h-8 rounded-full mr-3 object-cover">
                                <div class="flex-1">
                                    <div class="text-xs font-bold text-white">{{ $msg->user->name }}</div>
                                    <p class="text-[10px] text-gray-400 truncate">{{ $msg->mensagem }}</p>
                                </div>
                                <span class="text-[8px] text-gray-500">{{ $msg->created_at->diffForHumans() }}</span>
                            </a>
                        @empty
                            <p class="text-center text-gray-500 italic text-xs py-4">Nenhuma mensagem recente.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-mentora-layout>
