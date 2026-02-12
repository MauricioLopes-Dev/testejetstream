@php
    use App\Models\SiteSetting;
    
    // Busca slides do banco ou usa padrão
    $slidesJson = SiteSetting::get('about_slides');
    
    if ($slidesJson) {
        $slides = json_decode($slidesJson, true);
    } else {
        // Slides padrão
        $slides = [
            ['img' => 'sobre-1.jpg', 'title' => 'Nossa História', 'type' => 'Fundação 2025', 'desc' => 'O projeto Conectada com Ellas nasceu da paixão por promover a inclusão tecnológica.'],
            ['img' => 'sobre-2.jpg', 'title' => 'Oficinas', 'type' => 'Interatividade', 'desc' => 'Oferecemos oficinas práticas que capacitam mulheres de todas as idades no mundo digital.'],
            ['img' => 'sobre-3.jpg', 'title' => 'Comunidade', 'type' => 'Rede de Apoio', 'desc' => 'Uma rede colaborativa onde juntas superamos as barreiras do mercado de trabalho.'],
            ['img' => 'sobre-4.jpg', 'title' => 'Futuro', 'type' => 'Inovação', 'desc' => 'Conectamos talentos femininos com as oportunidades reais da era da tecnologia.'],
            ['img' => 'sobre-5.jpg', 'title' => 'Workshop', 'type' => 'Prática', 'desc' => 'Momentos de aprendizado intenso e troca de experiências fundamentais.'],
            ['img' => 'sobre-6.jpg', 'title' => 'Conexões', 'type' => 'Networking', 'desc' => 'Expandindo horizontes através de parcerias estratégicas no setor de TI.'],
            ['img' => 'sobre-7.jpg', 'title' => 'Liderança', 'type' => 'Empoderamento', 'desc' => 'Desenvolvendo competências para que mulheres ocupem cargos de decisão.'],
            ['img' => 'sobre-9.jpg', 'title' => 'Eventos', 'type' => 'Presença', 'desc' => 'Participação ativa nos maiores debates sobre tecnologia e sociedade.'],
            ['img' => 'sobre-10.jpg', 'title' => 'Impacto', 'type' => 'Resultados', 'desc' => 'Transformando realidades e criando um legado para as próximas gerações.'],
        ];
    }
@endphp

<section id="sobre" class="py-20 bg-ellas-card/50">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="slider relative w-full h-[750px] overflow-hidden rounded-3xl shadow-2xl border border-white/10 bg-black">
            
            <div class="list h-full relative">
                @foreach($slides as $slide)
                <div class="item absolute inset-0 flex flex-col lg:flex-row opacity-0 transition-opacity duration-1000 ease-in-out">
                    
                    <div class="content lg:w-5/12 w-full h-full p-8 lg:p-20 z-20 flex flex-col justify-center bg-black/60 backdrop-blur-md border-r border-white/5">
                        <div class="space-y-4 max-w-md">
                            <h5 class="font-orbitron text-ellas-pink tracking-[0.3em] uppercase text-xs sm:text-sm drop-shadow-lg">
                                {{ $slide['type'] }}
                            </h5>
                            
                            <h2 class="font-orbitron text-4xl lg:text-6xl font-bold text-white leading-tight drop-shadow-2xl">
                                {{ $slide['title'] }}
                            </h2>
                            
                            <div class="w-16 h-1.5 bg-ellas-pink rounded-full"></div>
                            
                            <p class="font-biorhyme text-gray-100 text-lg leading-relaxed pt-4 drop-shadow-md">
                                {{ $slide['desc'] }}
                            </p>
                            
                            <div class="pt-8">
                                <a href="{{ route('site.services') }}" class="inline-flex items-center px-10 py-4 bg-ellas-pink text-white font-bold rounded-full hover:bg-pink-600 transition-all shadow-lg shadow-pink-500/40 transform hover:-translate-y-1">
                                    Saiba Mais
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="absolute inset-0 lg:static lg:w-full h-full overflow-hidden -z-10 lg:z-0">
                        <img src="{{ asset('img/galeria/' . $slide['img']) }}" 
                             class="w-full h-full object-cover">
                        
                        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-transparent to-transparent hidden lg:block"></div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="absolute bottom-10 right-10 flex gap-4 z-30">
                <button class="prev w-14 h-14 border border-white/20 text-white flex items-center justify-center rounded-full hover:bg-ellas-pink hover:border-ellas-pink transition-all backdrop-blur-sm"> < </button>
                <button class="next w-14 h-14 bg-white text-black flex items-center justify-center rounded-full hover:bg-ellas-pink hover:text-white transition-all"> > </button>
            </div>
        </div>
    </div>
</section>

<style>
    .slider .list .item.active { opacity: 1 !important; position: relative; }
    .slider .list .item.active h2, 
    .slider .list .item.active p,
    .slider .list .item.active h5,
    .slider .list .item.active .pt-8 {
        animation: slideIn 0.8s ease-out forwards;
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const nextBtn = document.querySelector('.next');
        const prevBtn = document.querySelector('.prev');
        const items = document.querySelectorAll('.slider .list .item');
        let active = 0;

        function showSlider() {
            items.forEach(item => item.classList.remove('active'));
            items[active].classList.add('active');
        }

        nextBtn.onclick = () => {
            active = (active + 1 >= items.length) ? 0 : active + 1;
            showSlider();
        };

        prevBtn.onclick = () => {
            active = (active - 1 < 0) ? items.length - 1 : active - 1;
            showSlider();
        };

        showSlider();
    });
</script>
