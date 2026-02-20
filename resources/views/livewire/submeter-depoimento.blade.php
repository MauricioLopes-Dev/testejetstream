<div class="py-8 bg-ellas-dark">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-ellas-nav bg-ellas-dark/50">
                <h3 class="font-orbitron text-lg text-white font-bold flex items-center">
                    <i class="fas fa-star text-ellas-pink mr-3"></i>
                    COMPARTILHE SEU DEPOIMENTO
                </h3>
                <p class="text-xs text-gray-400 mt-2">Sua história pode inspirar outras mulheres! Compartilhe sua experiência com a Conectada com ELLAS.</p>
            </div>

            <!-- Conteúdo -->
            <div class="p-6">
                @if(session('message'))
                    <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-lg font-biorhyme text-sm">
                        {{ session('message') }}
                    </div>
                @endif

                @if($depoimentoEnviado)
                    <div class="text-center py-12">
                        <i class="fas fa-check-circle text-6xl text-green-500 mb-4"></i>
                        <h4 class="font-orbitron text-xl text-white font-bold mb-2">Depoimento Enviado!</h4>
                        <p class="text-gray-400 font-biorhyme mb-6">Obrigada por compartilhar sua história! Seu depoimento será revisado e em breve aparecerá no site.</p>
                        <button wire:click="$set('depoimentoEnviado', false)" class="px-6 py-2 bg-ellas-purple hover:bg-ellas-pink text-white rounded-lg font-bold text-xs uppercase transition-all">
                            ENVIAR OUTRO DEPOIMENTO
                        </button>
                    </div>
                @else
                    <form wire:submit.prevent="enviarDepoimento" class="space-y-6">
                        <div>
                            <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">Seu Nome</label>
                            <input 
                                type="text" 
                                wire:model.defer="nome" 
                                placeholder="Como você gostaria de ser identificada?" 
                                class="w-full bg-ellas-dark border border-ellas-nav text-white placeholder-gray-600 focus:border-ellas-cyan focus:ring-2 focus:ring-ellas-cyan/30 rounded-lg py-3 px-4 transition-all"
                            >
                            @error('nome') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">Sua Profissão / Cargo</label>
                            <input 
                                type="text" 
                                wire:model.defer="profissao" 
                                placeholder="Ex: Desenvolvedora Front-end, Estudante de TI, etc." 
                                class="w-full bg-ellas-dark border border-ellas-nav text-white placeholder-gray-600 focus:border-ellas-cyan focus:ring-2 focus:ring-ellas-cyan/30 rounded-lg py-3 px-4 transition-all"
                            >
                            @error('profissao') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">Seu Depoimento</label>
                            <textarea 
                                wire:model.defer="depoimento" 
                                placeholder="Conte-nos sobre sua experiência com a Conectada com ELLAS. Como o projeto impactou sua vida? O que você aprendeu?" 
                                rows="6"
                                class="w-full bg-ellas-dark border border-ellas-nav text-white placeholder-gray-600 focus:border-ellas-cyan focus:ring-2 focus:ring-ellas-cyan/30 rounded-lg py-3 px-4 transition-all"
                            ></textarea>
                            @error('depoimento') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-orbitron text-xs text-gray-400 uppercase mb-2">Link da Foto (Opcional)</label>
                            <input 
                                type="url" 
                                wire:model.defer="foto_url" 
                                placeholder="https://exemplo.com/sua-foto.jpg" 
                                class="w-full bg-ellas-dark border border-ellas-nav text-white placeholder-gray-600 focus:border-ellas-cyan focus:ring-2 focus:ring-ellas-cyan/30 rounded-lg py-3 px-4 transition-all"
                            >
                            @error('foto_url') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="flex-1 bg-gradient-to-r from-ellas-purple to-ellas-pink text-white py-3 rounded-lg font-orbitron font-bold hover:scale-105 transition-all shadow-lg">
                                <i class="fas fa-paper-plane mr-2"></i>ENVIAR DEPOIMENTO
                            </button>
                            <button type="button" wire:click="$set('showForm', false)" class="px-6 py-3 bg-ellas-nav text-gray-400 hover:text-white rounded-lg font-bold text-xs uppercase transition-all">
                                CANCELAR
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
