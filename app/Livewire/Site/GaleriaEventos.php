<?php

namespace App\Livewire\Site;

use Livewire\Component;
use App\Models\EventoPublico;

class GaleriaEventos extends Component
{
    public function render()
    {
        $eventos = EventoPublico::orderBy('data_realizacao', 'desc')->get();
        
        // Mudamos de 'layouts.guest' para 'layouts.site'
        return view('livewire.site.galeria-eventos', ['eventos' => $eventos])
            ->layout('layouts.site'); 
    }
}