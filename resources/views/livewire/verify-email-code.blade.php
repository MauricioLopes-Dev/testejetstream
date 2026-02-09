<div>
    <form wire:submit.prevent="verify" class="w-full">
        <div class="mb-4">
            <label for="code" class="block font-orbitron text-sm text-gray-400 mb-2">Código de 6 Dígitos</label>
            <input wire:model.defer="code" type="text" id="code" maxlength="6" 
                class="w-full bg-ellas-dark/50 border border-ellas-cyan/30 text-white rounded-xl px-4 py-3 focus:border-ellas-cyan focus:ring-1 focus:ring-ellas-cyan transition-all text-center text-2xl tracking-widest font-bold"
                placeholder="000000" required>
            
            @error('code')
                <span class="text-ellas-pink text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="w-full py-3 bg-ellas-cyan text-ellas-dark hover:bg-white rounded-xl font-orbitron font-bold transition-all duration-300 shadow-[0_0_15px_rgba(4,203,239,0.3)]">
            {{ __('Validar Cadastro') }}
        </button>
    </form>
</div>
