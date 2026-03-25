<x-guest-layout>
    <a href="/" class="absolute top-6 left-6 text-gray-400 hover:text-ellas-cyan transition-colors flex items-center gap-2 group z-50">
        <div class="w-8 h-8 rounded-full border border-ellas-nav flex items-center justify-center group-hover:border-ellas-cyan group-hover:bg-ellas-cyan/10 transition-all">
            <i class="fas fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform"></i>
        </div>
        <span class="font-orbitron text-sm hidden sm:inline">Voltar</span>
    </a>

    <div class="text-center py-8">
        <!-- Ícone animado -->
        <div class="relative inline-block mb-8">
            <div class="w-24 h-24 rounded-full bg-gradient-to-r from-ellas-purple/20 to-ellas-pink/20 flex items-center justify-center mx-auto animate-pulse">
                <i class="fas fa-hourglass-half text-4xl text-ellas-pink"></i>
            </div>
            <div class="absolute -top-1 -right-1 w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center">
                <i class="fas fa-clock text-xs text-white"></i>
            </div>
        </div>

        <h2 class="font-orbitron text-2xl text-white mb-4">
            Cadastro em <span class="text-transparent bg-clip-text bg-gradient-to-r from-ellas-purple to-ellas-pink">Análise</span>
        </h2>

        <div class="bg-ellas-dark/50 border border-ellas-nav rounded-xl p-6 mb-6 max-w-md mx-auto">
            <p class="font-biorhyme text-gray-300 text-sm leading-relaxed">
                Seu cadastro como <strong class="text-ellas-pink">mentora</strong> foi recebido com sucesso e está sendo analisado pela nossa equipe administrativa.
            </p>
            <div class="mt-4 pt-4 border-t border-ellas-nav">
                <p class="text-xs text-gray-500">
                    <i class="fas fa-info-circle text-ellas-cyan mr-1"></i>
                    Você receberá um e-mail assim que seu cadastro for aprovado ou se precisarmos de mais informações.
                </p>
            </div>
        </div>

        <div class="space-y-3 max-w-md mx-auto">
            <div class="flex items-center gap-3 bg-green-500/10 border border-green-500/20 rounded-lg p-3">
                <i class="fas fa-check-circle text-green-400"></i>
                <span class="text-sm text-green-300 font-biorhyme">E-mail verificado com sucesso</span>
            </div>
            <div class="flex items-center gap-3 bg-yellow-500/10 border border-yellow-500/20 rounded-lg p-3">
                <i class="fas fa-spinner fa-spin text-yellow-400"></i>
                <span class="text-sm text-yellow-300 font-biorhyme">Aguardando aprovação do administrador</span>
            </div>
        </div>

        {{-- Instrução sobre o acesso --}}
        <div class="mt-6 bg-ellas-purple/10 border border-ellas-purple/30 rounded-xl p-5 max-w-md mx-auto">
            <div class="flex items-start gap-3 text-left">
                <i class="fas fa-envelope text-ellas-purple mt-1"></i>
                <div>
                    <p class="text-sm text-white font-orbitron font-bold mb-1">Como vou acessar?</p>
                    <p class="text-xs text-gray-300 font-biorhyme leading-relaxed">
                        Quando seu cadastro for aprovado, você receberá um <strong class="text-ellas-cyan">e-mail com o link exclusivo</strong> para acessar o painel de mentora. Fique de olho na sua caixa de entrada e no spam!
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-ellas-purple to-ellas-pink rounded-xl font-orbitron font-bold text-white shadow-lg hover:scale-[1.02] transition-all text-sm">
                <i class="fas fa-home mr-2"></i> VOLTAR AO INÍCIO
            </a>
        </div>

        @if(session('info'))
            <div class="mt-6 p-4 bg-blue-500/20 border border-blue-500/30 text-blue-300 rounded-lg text-sm font-biorhyme max-w-md mx-auto">
                <i class="fas fa-info-circle mr-2"></i>{{ session('info') }}
            </div>
        @endif
    </div>
</x-guest-layout>
