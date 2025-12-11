<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Solicitacao;

class AgendaCalendario extends Component
{
    public function render()
    {
        $user = Auth::user();

        // Busca eventos inscritos
        $eventos = $user->eventosParticipando()
                        ->where('data_hora', '>=', now())
                        ->orderBy('data_hora', 'asc')
                        ->get();

        // Busca mentorias agendadas (Assumindo que a data de atualização é a data combinada ou apenas listando como compromisso)
        // Idealmente, mentorias teriam uma data agendada específica no futuro, mas usaremos os aceitos por enquanto.
        $mentorias = Solicitacao::with('mentora')
                                ->where('aluna_id', $user->id)
                                ->where('status', 'aceito')
                                ->get();

        // Mescla e ordena por data (Para fins de visualização simples, vamos focar nos Eventos que têm data fixa)
        // Uma melhoria futura seria adicionar campo de data na tabela de solicitações de mentoria.
        
        // Agrupa eventos por dia para o calendário
        $calendario = $eventos->groupBy(function($evento) {
            return $evento->data_hora->format('Y-m-d');
        });

        return view('livewire.agenda-calendario', [
            'calendario' => $calendario,
            'mentorias' => $mentorias
        ])->layout('layouts.app');
    }
}