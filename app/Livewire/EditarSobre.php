<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Auth;

class EditarSobre extends Component
{
    public $slides = [];

    public function mount()
    {
        // CORREÇÃO 1: Verifica explicitamente o guard 'admin'
        // Auth::user() padrão busca alunas e retornaria null aqui.
        if (!Auth::guard('admin')->check()) {
            abort(403, 'Acesso não autorizado. Apenas administradores.');
        }

        // Carrega os slides do banco ou usa padrão
        $slidesJson = SiteSetting::get('about_slides');
        
        if ($slidesJson) {
            $this->slides = json_decode($slidesJson, true);
        } else {
            // Slides padrão (caso não tenha nada salvo ainda)
            $this->slides = [
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
    }

    public function adicionarSlide()
    {
        $this->slides[] = [
            'img' => 'sobre-1.jpg',
            'title' => 'Novo Slide',
            'type' => 'Categoria',
            'desc' => 'Descrição do slide'
        ];
    }

    public function removerSlide($index)
    {
        unset($this->slides[$index]);
        $this->slides = array_values($this->slides); // Reindexar array para evitar buracos nos índices
    }

    public function salvar()
    {
        // Validação básica
        foreach ($this->slides as $slide) {
            if (empty($slide['title']) || empty($slide['desc'])) {
                session()->flash('error', 'Todos os slides devem ter título e descrição.');
                return;
            }
        }

        // Salva no banco (usando o Model SiteSetting que criamos)
        SiteSetting::set('about_slides', json_encode($this->slides));
        
        session()->flash('message', 'Conteúdo "Sobre" atualizado com sucesso!');
    }

    public function render()
    {
        // CORREÇÃO 2: Usa o layout do painel administrativo
        return view('livewire.editar-sobre')->layout('layouts.admin');
    }
}