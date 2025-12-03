<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
            
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Complete seu Perfil</h2>

            <form wire:submit.prevent="salvar">
                
            <div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2">Seu Perfil Atual:</label>
    <div class="p-3 bg-gray-100 rounded text-gray-600">
        @if($role === 'mentora')
            🎓 Mentora Verificada
        @else
            👩‍💻 Aluna / Entusiasta
        @endif
    </div>
    <p class="text-xs text-gray-500 mt-1">
        Deseja ser uma mentora? <a href="#" class="text-blue-500 underline">Aplique aqui futuramente.</a>
    </p>
</div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Área de Atuação / Interesse</label>
                    <input type="text" wire:model="area_atuacao" placeholder="Ex: Backend, UX Design, Data Science" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @error('area_atuacao') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">LinkedIn (URL)</label>
                    <input type="text" wire:model="linkedin_url" placeholder="https://linkedin.com/in/voce" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Sobre Mim</label>
                    <textarea wire:model="bio" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Salvar Perfil
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>