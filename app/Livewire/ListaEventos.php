<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class ListaEventos extends Component
{
    public function participar($eventId)
    {
        $evento = Event::find($eventId);

        if (!$evento) return;
        if ($evento->estaLotado()) return;

        // Adiciona o usuário na lista de participantes
        $evento->participantes()->attach(Auth::id());
        
        session()->flash('success', 'Inscrição confirmada! O evento agora aparecerá em "Meus Cursos".');
    }

    public function sair($eventId)
    {
        $evento = Event::find($eventId);
        if ($evento) {
            // detach = Remove da tabela pivô (Desinscreve)
            $evento->participantes()->detach(Auth::id());
        }
    }

    public function render()
    {
        // FILTRO ATIVADO: Mostrar apenas eventos futuros (data_hora >= agora)
        // Alterei também para 'asc' para mostrar os eventos mais próximos primeiro (amanhã, depois de amanhã...)
        $eventos = Event::with('participantes')
            ->where('data_hora', '>=', now()) 
            ->orderBy('data_hora', 'asc') 
            ->get();

        return view('livewire.lista-eventos', ['eventos' => $eventos])
            ->layout('layouts.app');
    }
}