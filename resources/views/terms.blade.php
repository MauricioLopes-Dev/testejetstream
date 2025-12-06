<x-guest-layout>
    <div class="pt-4 bg-ellas-dark min-h-screen flex flex-col items-center">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-2xl mt-6 p-8 bg-ellas-card shadow-2xl border border-ellas-nav overflow-hidden sm:rounded-2xl prose prose-invert max-w-none">
                
                <div class="text-center mb-8">
                    <h1 class="font-orbitron text-3xl text-white mb-2">Termos de Serviço</h1> <div class="h-1 w-20 bg-ellas-gradient mx-auto rounded-full"></div>
                </div>

                <div class="font-biorhyme text-gray-300 text-justify leading-relaxed space-y-4">
                    {!! $terms !!} </div>
                
                <div class="mt-8 text-center">
                    <a href="/" class="font-orbitron text-ellas-cyan hover:text-white transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Voltar para o Início
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>