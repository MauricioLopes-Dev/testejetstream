<div class="w-full">
    <form wire:submit.prevent="verify" class="space-y-6">
        <div class="flex justify-between gap-2 sm:gap-4" x-data="{ 
            handleInput(e, index) {
                const val = e.target.value;
                if (val.length > 0) {
                    if (index < 5) {
                        this.$refs['digit' + (index + 1)].focus();
                    }
                }
            },
            handleBackspace(e, index) {
                if (e.target.value.length === 0 && index > 0) {
                    this.$refs['digit' + (index - 1)].focus();
                }
            }
        }">
            @foreach($digits as $index => $digit)
                <input 
                    wire:model.live="digits.{{ $index }}"
                    x-ref="digit{{ $index }}"
                    x-on:input="handleInput($event, {{ $index }})"
                    x-on:keydown.backspace="handleBackspace($event, {{ $index }})"
                    type="text" 
                    maxlength="1" 
                    class="w-12 h-14 sm:w-14 sm:h-16 bg-ellas-dark/50 border border-ellas-cyan/30 text-white rounded-xl text-center text-2xl font-bold focus:border-ellas-cyan focus:ring-1 focus:ring-ellas-cyan transition-all shadow-[0_0_10px_rgba(4,203,239,0.1)]"
                    placeholder="-"
                    required
                >
            @endforeach
        </div>

        @error('code')
            <div class="text-ellas-pink text-sm text-center font-biorhyme animate-pulse">
                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
            </div>
        @enderror

        <button type="submit" class="w-full py-4 bg-gradient-to-r from-ellas-purple via-ellas-pink to-ellas-cyan text-white rounded-xl font-orbitron font-bold transition-all duration-500 hover:scale-[1.02] hover:shadow-[0_0_20px_rgba(227,20,117,0.4)] active:scale-[0.98]">
            {{ __('VALIDAR ACESSO') }}
        </button>
    </form>
</div>
