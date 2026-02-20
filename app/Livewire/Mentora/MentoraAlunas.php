<?php

namespace App\Livewire\Mentora;

use Livewire\Component;
use App\Models\User;
use App\Models\Curso;
use Illuminate\Support\Facades\Auth;

class MentoraAlunas extends Component
{
    public $alunas;
    public $alunaDetalhes = null;
    public $showModal = false;

    public function mount()
    {
        if (!Auth::guard('mentora')->check()) {
            abort(403);
        }
        $this->carregarAlunas();
    }

    public function carregarAlunas()
    {
        $mentora = Auth::guard('mentora')->user();
        $cursosIds = $mentora->cursos()->pluck('id');
        
        $this->alunas = User::whereHas('cursos', function($query) use ($cursosIds) {
            $query->whereIn('cursos.id', $cursosIds);
        })->with(['cursos' => function($query) use ($cursosIds) {
            $query->whereIn('cursos.id', $cursosIds);
        }])->get();
    }

    public function verDetalhes($alunaId)
    {
        $this->alunaDetalhes = User::with('cursos')->find($alunaId);
        $this->showModal = true;
    }

    public function fecharModal()
    {
        $this->showModal = false;
        $this->alunaDetalhes = null;
    }

    public function render()
    {
        return view('livewire.mentora.mentora-alunas')->layout('layouts.mentora');
    }
}
