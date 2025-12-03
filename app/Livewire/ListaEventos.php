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

        // Validações
        if (!$evento) return;
        if ($evento->estaLotado()) return;

        // attach = Adiciona na tabela pivô (Inscreve)
        // O segundo parametro (array vazio) é necessário em algumas versões, mas aqui o simples funciona
        $evento->participantes()->attach(Auth::id());
        
        // Dispara um evento pro navegador saber que atualizou (opcional, mas bom pra UI)
        session()->flash('success', 'Inscrição confirmada!');
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
        // Traz os eventos ordenados pela data
        // Traz também a relação 'participantes' para sabermos se EU estou lá
        $eventos = Event::with('participantes')
            ->where('data_hora', '>=', now()) // Só eventos futuros
            ->orderBy('data_hora', 'asc')
            ->get();

        return view('livewire.lista-eventos', ['eventos' => $eventos])
            ->layout('layouts.app');
    }
}