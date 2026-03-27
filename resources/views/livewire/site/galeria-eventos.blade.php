<div class="min-h-screen bg-ellas-dark pt-32 pb-20 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-ellas-purple/20 to-transparent opacity-50 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <h5 class="font-orbitron text-ellas-cyan tracking-widest uppercase text-sm mb-2">Nosso Histórico</h5>
            <h2 class="font-orbitron text-4xl md:text-5xl font-bold text-white mb-4">
                Galeria de <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-pink to-ellas-cyan">Eventos</span>
            </h2>
            <p class="font-biorhyme text-gray-400 text-lg max-w-2xl mx-auto mb-8">Reviva os melhores momentos dos nossos encontros.</p>

            @if(Auth::guard('admin')->check())
                <a href="{{ route('admin.galeria.gerenciar') }}" class="inline-flex items-center gap-2 font-orbitron px-8 py-3 rounded-full bg-ellas-dark border border-ellas-cyan text-ellas-cyan hover:bg-ellas-cyan hover:text-ellas-dark transition-all shadow-[0_0_15px_rgba(4,203,239,0.3)]">
                    <i class="fas fa-plus-circle"></i> Gerenciar Álbuns
                </a>
            @endif
        </div>

        @if($eventos->isEmpty())
            <div class="text-center py-20 text-gray-500">
                <i class="fas fa-photo-video text-5xl mb-4 text-ellas-nav"></i>
                <p class="font-orbitron text-xl">Nenhum álbum disponível ainda.</p>
            </div>
        @else
            <div class="space-y-20">
                @foreach($eventos as $evento)
                    <div class="bg-ellas-card border border-ellas-nav rounded-3xl p-8 shadow-xl">
                        
                        <div class="text-center md:text-left mb-8 border-b border-ellas-nav pb-6">
                            <span class="inline-block bg-ellas-dark border border-ellas-cyan text-ellas-cyan px-4 py-1 rounded-full font-orbitron text-sm mb-4">
                                <i class="fas fa-calendar-alt mr-2"></i>{{ $evento->data_realizacao->format('d/m/Y') }}
                            </span>
                            <h3 class="font-orbitron text-3xl font-bold text-white mb-4">{{ $evento->titulo }}</h3>
                            <p class="font-biorhyme text-gray-400 max-w-4xl">{{ $evento->descricao }}</p>
                        </div>

                        @if(is_array($evento->midias) && count($evento->midias) > 0)
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($evento->midias as $caminho)
                                    @php
                                        $ext = pathinfo($caminho, PATHINFO_EXTENSION);
                                        $isVid = in_array(strtolower($ext), ['mp4', 'mov', 'webm']);
                                    @endphp

                                    <div class="relative h-48 rounded-2xl overflow-hidden bg-black group shadow-lg border border-transparent hover:border-ellas-pink transition-all">
                                        @if($isVid)
                                            <video src="{{ Storage::url($caminho) }}" controls class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity"></video>
                                        @else
                                            <img src="{{ Storage::url($caminho) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm italic font-biorhyme text-center py-4">Nenhuma mídia anexada a este evento.</p>
                        @endif

                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>