<div class="py-10 bg-ellas-dark min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h2 class="text-3xl font-orbitron font-bold text-white">Gerenciar <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-cyan to-ellas-purple">Álbuns de Eventos</span></h2>
            <p class="text-gray-400 font-biorhyme mt-1">Poste várias fotos e vídeos de uma vez para cada evento.</p>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-500/20 border border-green-500 text-green-400 px-6 py-4 rounded-xl mb-8 flex items-center">
                <i class="fas fa-check-circle text-xl mr-3"></i>
                <span class="font-biorhyme font-semibold">{{ session('message') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-ellas-cyan to-ellas-purple"></div>
                    <h3 class="font-orbitron text-xl text-white mb-6"><i class="fas fa-plus-circle text-ellas-cyan mr-2"></i> Novo Álbum</h3>

                    <form wire:submit.prevent="salvar" class="space-y-5">
                        <div>
                            <label class="block font-orbitron text-sm text-gray-300 mb-1">Título do Evento</label>
                            <input type="text" wire:model="titulo" class="w-full bg-ellas-dark border border-ellas-nav rounded-lg px-4 py-2 text-white focus:ring-ellas-cyan">
                            @error('titulo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-orbitron text-sm text-gray-300 mb-1">Data</label>
                            <input type="date" wire:model="data_realizacao" class="w-full bg-ellas-dark border border-ellas-nav rounded-lg px-4 py-2 text-white focus:ring-ellas-cyan color-scheme-dark">
                            @error('data_realizacao') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-orbitron text-sm text-gray-300 mb-1">Descrição</label>
                            <textarea wire:model="descricao" rows="3" class="w-full bg-ellas-dark border border-ellas-nav rounded-lg px-4 py-2 text-white focus:ring-ellas-cyan"></textarea>
                            @error('descricao') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-orbitron text-sm text-gray-300 mb-2">Fotos e Vídeos (Pode selecionar vários)</label>
                            <input type="file" wire:model="midias" multiple accept="image/*,video/*" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-ellas-cyan/10 file:text-ellas-cyan hover:file:bg-ellas-cyan/20 cursor-pointer">
                            @error('midias.*') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            @error('midias') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            
                            @if ($midias)
                                <div class="mt-4 grid grid-cols-3 gap-2">
                                    @foreach($midias as $midia)
                                        @php
                                            $isVideo = in_array(strtolower($midia->getClientOriginalExtension()), ['mp4', 'mov', 'webm']);
                                        @endphp
                                        <div class="rounded-lg overflow-hidden border border-ellas-nav h-20 bg-black flex items-center justify-center relative">
                                            @if($isVideo)
                                                <i class="fas fa-play text-white/50 absolute z-10"></i>
                                                <video src="{{ $midia->temporaryUrl() }}" class="w-full h-full object-cover opacity-50"></video>
                                            @else
                                                <img src="{{ $midia->temporaryUrl() }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-xs text-ellas-cyan mt-2 text-right">{{ count($midias) }} arquivo(s) selecionado(s)</p>
                            @endif
                        </div>

                        <button type="submit" class="w-full mt-4 bg-gradient-to-r from-ellas-cyan to-blue-600 text-white font-orbitron font-bold py-3 px-4 rounded-xl shadow-[0_0_15px_rgba(4,203,239,0.4)] hover:scale-[1.02] transition-transform">
                            <span wire:loading.remove wire:target="salvar">Publicar Álbum</span>
                            <span wire:loading wire:target="salvar"><i class="fas fa-circle-notch fa-spin mr-2"></i> Fazendo Upload...</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="space-y-6">
                    <h3 class="font-orbitron text-xl text-white"><i class="fas fa-images text-ellas-pink mr-2"></i> Álbuns Publicados ({{ $eventos->count() }})</h3>

                    @if($eventos->isEmpty())
                        <div class="text-center py-10 bg-ellas-card rounded-xl border border-dashed border-ellas-nav">
                            <i class="fas fa-photo-video text-4xl text-gray-600 mb-3"></i>
                            <p class="font-biorhyme text-gray-500">Nenhum álbum criado.</p>
                        </div>
                    @else
                        @foreach($eventos as $evento)
                            <div class="bg-ellas-card border border-ellas-nav rounded-2xl p-6 shadow-xl relative">
                                
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                                    <div>
                                        <h4 class="font-orbitron text-2xl text-white font-bold">{{ $evento->titulo }}</h4>
                                        <p class="text-ellas-cyan font-orbitron text-sm"><i class="fas fa-calendar-alt mr-2"></i>{{ $evento->data_realizacao->format('d/m/Y') }}</p>
                                    </div>
                                    
                                    <button wire:click="deletar({{ $evento->id }})" wire:confirm="Isso apagará o evento e TODOS os seus arquivos. Tem certeza?" class="bg-red-500/20 text-red-500 border border-red-500 hover:bg-red-500 hover:text-white px-4 py-2 rounded-lg font-orbitron text-sm font-bold transition-colors flex items-center gap-2">
                                        <i class="fas fa-trash-alt"></i> Apagar Álbum
                                    </button>
                                </div>
                                
                                <p class="text-gray-400 font-biorhyme mb-6 text-sm">{{ $evento->descricao }}</p>

                                <div class="flex overflow-x-auto gap-4 pb-4 snap-x scrollbar-hide">
                                    @if(is_array($evento->midias))
                                        @foreach($evento->midias as $caminho)
                                            @php
                                                $ext = pathinfo($caminho, PATHINFO_EXTENSION);
                                                $isVid = in_array(strtolower($ext), ['mp4', 'mov', 'webm']);
                                            @endphp
                                            <div class="min-w-[200px] h-32 rounded-xl overflow-hidden border border-ellas-nav bg-black flex-shrink-0 snap-center relative">
                                                @if($isVid)
                                                    <i class="fas fa-play text-white/70 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-2xl z-10 pointer-events-none"></i>
                                                    <video src="{{ Storage::url($caminho) }}" class="w-full h-full object-cover opacity-60"></video>
                                                @else
                                                    <img src="{{ Storage::url($caminho) }}" class="w-full h-full object-cover">
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</div>