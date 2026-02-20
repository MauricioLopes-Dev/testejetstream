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
                            <div class="text-ellas-cyan font-bold text-xl">{{ Auth::user()->cursos()->count() }}</div>
                            <div class="text-[10px] text-gray-500 uppercase font-orbitron">Cursos</div>
                        </div>
                        <div class="text-center px-6 py-3 bg-ellas-dark/50 rounded-xl border border-ellas-nav">
                            <div class="text-ellas-pink font-bold text-xl">{{ Auth::user()->eventosParticipando()->count() }}</div>
                            <div class="text-[10px] text-gray-500 uppercase font-orbitron">Eventos</div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Histórias e Eventos -->
                    <div class="bg-ellas-dark/40 border border-ellas-nav rounded-2xl p-6 hover:border-ellas-cyan/30 transition-all group">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 rounded-full bg-ellas-cyan/20 flex items-center justify-center text-ellas-cyan">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <h4 class="font-orbitron text-white font-bold uppercase tracking-wider">Explorar</h4>
                        </div>
                        <div class="space-y-4">
                            <a href="{{ route('blog.index') }}" class="block p-4 bg-ellas-dark/20 rounded-xl border border-ellas-nav hover:bg-ellas-purple/10 transition-all">
                                <div class="text-white font-bold text-sm">Histórias</div>
                                <p class="text-[10px] text-gray-500">Veja o que está acontecendo na comunidade</p>
                            </a>
                            <a href="{{ route('eventos.index') }}" class="block p-4 bg-ellas-dark/20 rounded-xl border border-ellas-nav hover:bg-ellas-pink/10 transition-all">
                                <div class="text-white font-bold text-sm">Eventos</div>
                                <p class="text-[10px] text-gray-500">Participe de workshops e encontros</p>
                            </a>
                        </div>
                    </div>

                    <!-- Cursos e Agenda -->
                    <div class="bg-ellas-dark/40 border border-ellas-nav rounded-2xl p-6 hover:border-ellas-purple/30 transition-all group">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 rounded-full bg-ellas-purple/20 flex items-center justify-center text-ellas-purple">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h4 class="font-orbitron text-white font-bold uppercase tracking-wider">Aprendizado</h4>
                        </div>
                        <div class="space-y-4">
                            <a href="{{ route('meus.cursos') }}" class="block p-4 bg-ellas-dark/20 rounded-xl border border-ellas-nav hover:bg-ellas-cyan/10 transition-all">
                                <div class="text-white font-bold text-sm">Meus Cursos</div>
                                <p class="text-[10px] text-gray-500">Acesse suas aulas e materiais</p>
                            </a>
                            <a href="{{ route('agenda.index') }}" class="block p-4 bg-ellas-dark/20 rounded-xl border border-ellas-nav hover:bg-ellas-purple/10 transition-all">
                                <div class="text-white font-bold text-sm">Minha Agenda</div>
                                <p class="text-[10px] text-gray-500">Não perca nenhuma aula ao vivo</p>
                            </a>
                        </div>
                    </div>

                    <!-- Perfil e Chat -->
                    <div class="bg-ellas-dark/40 border border-ellas-nav rounded-2xl p-6 hover:border-ellas-pink/30 transition-all group">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 rounded-full bg-ellas-pink/20 flex items-center justify-center text-ellas-pink">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <h4 class="font-orbitron text-white font-bold uppercase tracking-wider">Conexão</h4>
                        </div>
                        <div class="space-y-4">
                            <a href="{{ route('perfil.aluna') }}" class="block p-4 bg-ellas-dark/20 rounded-xl border border-ellas-nav hover:bg-ellas-pink/10 transition-all">
                                <div class="text-white font-bold text-sm">Meu Perfil</div>
                                <p class="text-[10px] text-gray-500">Mantenha seus dados atualizados</p>
                            </a>
                            @php
                                $ultimaMentora = Auth::user()->cursos()->whereNotNull('mentora_id')->first()?->mentora_id;
                            @endphp
                            @if($ultimaMentora)
                                <a href="{{ route('chat.duvidas', ['mentoraId' => $ultimaMentora]) }}" class="block p-4 bg-ellas-dark/20 rounded-xl border border-ellas-nav hover:bg-ellas-cyan/10 transition-all">
                                    <div class="text-white font-bold text-sm">Dúvidas</div>
                                    <p class="text-[10px] text-gray-500">Fale com sua mentora</p>
                                </a>
                            @else
                                <div class="block p-4 bg-ellas-dark/10 rounded-xl border border-dashed border-ellas-nav opacity-50">
                                    <div class="text-gray-500 font-bold text-sm">Dúvidas</div>
                                    <p class="text-[10px] text-gray-500">Inscreva-se em um curso para habilitar</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
