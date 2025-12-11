<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MeusCursos extends Component
{
    public function render()
    {
        $user = Auth::user();

        // Busca apenas eventos que a aluna está inscrita
        // Aqui o foco não é data, é acesso ao conteúdo, então ordenamos pelos mais recentes
        $cursos = $user->eventosParticipando()
                       ->orderByDesc('data_hora')
                       ->get();

        return view('livewire.meus-cursos', [
            'cursos' => $cursos
        ])->layout('layouts.app');
    }
}