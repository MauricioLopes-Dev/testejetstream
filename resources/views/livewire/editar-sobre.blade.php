<div class="py-12 bg-ellas-dark min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-ellas-card border border-ellas-nav rounded-2xl shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-ellas-nav flex items-center justify-between">
                <div>
                    <h3 class="font-orbitron text-lg text-white font-bold flex items-center">
                        <i class="fas fa-edit text-ellas-purple mr-3"></i>
                        EDITAR SEÇÃO "SOBRE"
                    </h3>
                    <p class="font-biorhyme text-gray-400 text-sm mt-2">Gerencie os slides da seção sobre o projeto</p>
                </div>
                <button wire:click="adicionarSlide" class="px-4 py-2 bg-ellas-purple text-white rounded-lg hover:bg-ellas-pink transition-all font-orbitron text-xs">
                    <i class="fas fa-plus mr-2"></i>ADICIONAR SLIDE
                </button>
            </div>

            <div class="p-8">
                @if(session('message'))
                    <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-lg font-biorhyme text-sm">
                        {{ session('message') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 text-red-400 rounded-lg font-biorhyme text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <form wire:submit.prevent="salvar" class="space-y-6">
                    @foreach($slides as $index => $slide)
                        <div class="bg-ellas-dark/50 border border-ellas-nav rounded-xl p-6 relative">
                            <button type="button" wire:click="removerSlide({{ $index }})" class="absolute top-4 right-4 text-red-500 hover:text-red-400 transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Imagem (nome do arquivo)</label>
                                    <input type="text" wire:model="slides.{{ $index }}.img" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" placeholder="sobre-1.jpg">
                                </div>

                                <div>
                                    <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Categoria</label>
                                    <input type="text" wire:model="slides.{{ $index }}.type" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" placeholder="Fundação 2025">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Título</label>
                                <input type="text" wire:model="slides.{{ $index }}.title" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" placeholder="Nossa História" required>
                            </div>

                            <div>
                                <label class="block text-gray-300 font-orbitron text-xs uppercase mb-2">Descrição</label>
                                <textarea wire:model="slides.{{ $index }}.desc" rows="3" class="w-full bg-ellas-dark border-ellas-nav text-white rounded-lg px-4 py-2 focus:ring-ellas-purple focus:border-ellas-purple" placeholder="Descrição do slide" required></textarea>
                            </div>
                        </div>
                    @endforeach

                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-ellas-nav">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white font-orbitron text-xs uppercase transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-lg hover:scale-[1.02] transition-all">
                            SALVAR ALTERAÇÕES
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
