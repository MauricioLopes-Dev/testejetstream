<x-guest-layout>
    <div x-data="{ recovery: false }">
        <div class="mb-8 mt-4 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-ellas-purple/20 text-ellas-purple mb-4 border border-ellas-purple/50 shadow-[0_0_15px_rgba(165,4,170,0.3)]">
                <i class="fas fa-shield-alt text-2xl"></i>
            </div>
            
            <h2 class="font-orbitron text-2xl text-white mb-2">Segurança Extra</h2>
            
            <p class="font-biorhyme text-gray-400 text-sm" x-show="! recovery">
                Confirme o acesso usando o código do seu aplicativo autenticador.
            </p>

            <p class="font-biorhyme text-gray-400 text-sm" x-show="recovery" x-cloak>
                Confirme o acesso usando um dos seus códigos de recuperação de emergência.
            </p>
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf

            <div class="mt-4" x-show="! recovery">
                <x-label for="code" value="{{ __('Código de Autenticação') }}" class="text-center" />
                <x-input id="code" class="block w-full text-center text-2xl tracking-[0.5em] font-orbitron text-ellas-cyan border-ellas-cyan/50 focus:border-ellas-cyan focus:ring-ellas-cyan" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" placeholder="000000" />
            </div>

            <div class="mt-4" x-show="recovery" x-cloak>
                <x-label for="recovery_code" value="{{ __('Código de Recuperação') }}" class="text-center" />
                <x-input id="recovery_code" class="block w-full text-center font-mono text-lg" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" placeholder="XXXXXXXX-XXXXXXXX" />
            </div>

            <div class="flex items-center justify-end mt-6 flex-col gap-4">
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-[0_0_20px_rgba(227,20,117,0.3)] hover:shadow-[0_0_30px_rgba(227,20,117,0.5)] hover:scale-[1.02] transition-all duration-300">
                    {{ __('Autenticar') }}
                </button>

                <button type="button" class="text-sm text-ellas-cyan hover:text-white underline font-orbitron transition cursor-pointer"
                                x-show="! recovery"
                                x-on:click="
                                    recovery = true;
                                    $nextTick(() => { $refs.recovery_code.focus() })
                                ">
                    {{ __('Usar código de recuperação') }}
                </button>

                <button type="button" class="text-sm text-ellas-pink hover:text-white underline font-orbitron transition cursor-pointer"
                                x-show="recovery"
                                x-cloak
                                x-on:click="
                                    recovery = false;
                                    $nextTick(() => { $refs.code.focus() })
                                ">
                    {{ __('Usar código de autenticação') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>