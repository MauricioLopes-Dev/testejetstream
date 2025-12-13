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

        $evento->participantes()->attach(Auth::id());
        
        session()->flash('success', 'Inscrição confirmada! O evento agora aparecerá em "Meus Cursos".');
    }

    public function sair($eventId)
    {
        $evento = Event::find($eventId);
        if ($evento) {
            $evento->participantes()->detach(Auth::id());
        }
    }

    public function render()
    {
        // CORREÇÃO: Usamos subDays(1) para incluir eventos das últimas 24h
        // Isso resolve o problema de fuso horário onde o evento sumia logo após ser criado
        $eventos = Event::with('participantes')
            ->where('data_hora', '>=', now()->subDays(1)) 
            ->orderBy('data_hora', 'asc')
            ->get();

        return view('livewire.lista-eventos', ['eventos' => $eventos])
            ->layout('layouts.app');
    }
}