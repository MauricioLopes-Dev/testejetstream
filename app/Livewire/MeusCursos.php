<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MeusCursos extends Component
{
    public function render()
    {
        $user = Auth::user();

        // 1. Busca todos os eventos em que a usuária se inscreveu
        $todosCursos = $user->eventosParticipando()
                            ->orderByDesc('data_hora')
                            ->get();

        // 2. Filtra na coleção (memória) para separar o que é futuro do que é passado
        $proximasAulas = $todosCursos->where('data_hora', '>=', now());
        $aulasPassadas = $todosCursos->where('data_hora', '<', now());

        // 3. Envia as duas variáveis para a view
        return view('livewire.meus-cursos', [
            'proximasAulas' => $proximasAulas,
            'aulasPassadas' => $aulasPassadas
        ])->layout('layouts.app');
    }
}